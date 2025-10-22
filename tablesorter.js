/**
 * Copyright Christoph M. Becker
 *
 * This file is part of Tablesorter_XH.
 *
 * Tablesorter_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Tablesorter_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tablesorter_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

// jshint browser:true,esversion:5,latedef:nofunc,strict:true

(function () {
    "use strict";

    /**
     * @typedef {Object} Config
     * @prop {boolean} sortable
     * @prop {number} maxPages
     * @prop {number} widthLarge
     * @prop {number} widthMedium
     * @prop {number} widthSmall
     * @prop {number} widthXSmall
     * @prop {string} locale
     * @prop {string} columns
     * @prop {string} show
     * @prop {string} hide
     */

    /** @type {<T>(arrayLike: ArrayLike<T>) => T[]} */
    function array(arrayLike) {
        return Array.prototype.slice.call(arrayLike);
    }

    /** @type {Config} */
    var config;

    /** @readonly */
    var widgetProto = Object.seal({
        /** @type {HTMLTableElement} */
        table: undefined,
        /** @type {number[]} */
        hiddenColumns: undefined,
        /** @type {Element[]} */
        headings: undefined,
        /** @type {HTMLOListElement} */
        selectionList: undefined,
        /** @type {boolean[]} */
        userColumns: undefined,
        /** @type {number} */
        currentPage: undefined,

        /** @type {() => void} */
        paginate: function () {
            var self = this;
            /** @type {(index: number) => HTMLButtonElement} */
            function makePaginationButton(index) {
                var button = document.createElement("button");
                button.textContent = String(index + 1);
                if (index === self.currentPage) {
                    button.disabled = true;
                }
                button.onclick = function () {
                    self.currentPage = index;
                    self.paginate();
                };
                return button;
            }

            (function () {
                self.collapseDetails();
                var rows = self.table.tBodies[0].rows;
                var pageCount = Math.ceil(rows.length / config.maxPages);
                var start = self.currentPage * config.maxPages;
                var end = (self.currentPage + 1) * config.maxPages - 1;
                array(rows).forEach(function (row, index) {
                    row.style.display = index >= start && index <= end ? "" : "none";
                });
                if (pageCount > 1) {
                    var pagination = document.createElement("div");
                    pagination.className = "tablesorter_pagination";
                    /** @type {number[]} */ (
                        Array.apply(undefined, Array(pageCount)).map(Number.call, Number)
                    ).forEach(function (index) {
                        var button = makePaginationButton(index);
                        pagination.appendChild(button);
                    });
                    if (
                        self.table.nextElementSibling &&
                        self.table.nextElementSibling.classList.contains("tablesorter_pagination")
                    ) {
                        self.table.nextElementSibling.parentNode.removeChild(
                            self.table.nextElementSibling
                        );
                    }
                    self.table.parentNode.insertBefore(pagination, self.table.nextElementSibling);
                }
            })();
        },

        /** @type {(column: number, desc: boolean, numeric: boolean) => void} */
        sort: function (column, desc, numeric) {
            var tbody = this.table.tBodies[0];
            var rows = array(tbody.rows).map(function (tr) {
                var td = tr.cells[column];
                var value = td.textContent || "";
                return {
                    value: numeric ? +value : value,
                    element: tr
                };
            });
            if (!numeric) var collator = Intl.Collator(config.locale, { sensitivity: "base" });
            rows = rows.sort(function (a, b) {
                var order = desc ? -1 : 1;
                if (typeof a.value === "number" && typeof b.value === "number") {
                    return (a.value - b.value) * order;
                } else if (typeof a.value === "string" && typeof b.value === "string") {
                    return collator.compare(a.value, b.value) * order;
                } else {
                    throw "error";
                }
            });
            rows.forEach(function (value) {
                tbody.appendChild(value.element);
            });
        },

        /** @type {() => number[]} */
        determineHiddenColumns: function () {
            var breakpoints = /** @type {{[x: string]: number}} */ ({
                tablesorter_large: config.widthLarge,
                tablesorter_medium: config.widthMedium,
                tablesorter_small: config.widthSmall,
                tablesorter_x_small: config.widthXSmall
            });
            var result = /** @type {number[]} */ ([]);
            var classesToHide = Object.keys(breakpoints).filter(function (key) {
                return innerWidth < breakpoints[key];
            });
            var self = this;
            this.headings.forEach(function (heading, index) {
                if (self.userColumns[index] !== undefined) {
                    if (!self.userColumns[index]) {
                        result.push(index);
                    }
                } else if (heading.classList.contains("tablesorter_hide")) {
                    result.push(index);
                } else {
                    var alreadyHidden = false;
                    classesToHide.forEach(function (className) {
                        if (!alreadyHidden && heading.classList.contains(className)) {
                            result.push(index);
                            alreadyHidden = true;
                        }
                    });
                }
            });
            return result;
        },

        /** @type {() => void} */
        hideColumns: function () {
            var self = this;
            /** @type {(event: Event) => void} */
            function onMoreLessClick(event) {
                var button = /** @type {HTMLButtonElement} */ (event.currentTarget);
                var row = /** @type {HTMLTableRowElement} */ (button.parentElement.parentElement);
                var section = /** @type {HTMLTableSectionElement} */ (row.parentElement);
                if (button.className === "tablesorter_expand") {
                    var detailRow = section.insertRow(row.sectionRowIndex + 1);
                    detailRow.className = "tablesorter_detail";
                    var detailCell = detailRow.insertCell();
                    detailCell.colSpan = row.cells.length;
                    var defList = document.createElement("dl");
                    self.hiddenColumns.forEach(function (column) {
                        var dt = makeDt(column);
                        defList.appendChild(dt);
                        var dd = document.createElement("dd");
                        dd.innerHTML = row.cells[column].innerHTML;
                        defList.appendChild(dd);
                    });
                    detailCell.appendChild(defList);
                    button.className = "tablesorter_collapse";
                    button.textContent = config.hide;
                } else {
                    section.deleteRow(row.sectionRowIndex + 1);
                    button.className = "tablesorter_expand";
                    button.textContent = config.show;
                }
            }

            /** @type {(column: number) => HTMLElement} */
            function makeDt(column) {
                var dt = document.createElement("dt");
                var headingElement = self.headings[column];
                if (config.sortable) {
                    headingElement = /** @type {HTMLButtonElement} */ (headingElement.firstChild);
                }
                dt.innerHTML = headingElement.innerHTML;
                return dt;
            }

            (function () {
                if (!self.hiddenColumns.length) return;
                array(self.table.querySelectorAll("tr")).forEach(function (row) {
                    self.hiddenColumns.forEach(function (column) {
                        var cell = row.cells[column];
                        cell.style.display = "none";
                    });
                    row.insertCell();
                    if (row.parentElement && row.parentElement.nodeName.toLowerCase() === "tbody") {
                        var button = document.createElement("button");
                        button.className = "tablesorter_expand";
                        button.textContent = config.show;
                        button.onclick = onMoreLessClick;
                        var lastCell = row.cells[row.cells.length - 1];
                        lastCell.insertBefore(button, lastCell.firstElementChild);
                    }
                });
                var checkboxes = /** @type {HTMLInputElement[]} */ (
                    array(self.selectionList.querySelectorAll("input[type=checkbox]"))
                );
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = self.hiddenColumns.indexOf(Number(checkbox.value)) < 0;
                });
            })();
        },

        /** @type {() => void} */
        unhideColumns: function () {
            if (this.hiddenColumns.length) {
                var self = this;
                array(this.table.querySelectorAll("tr")).forEach(function (row) {
                    self.hiddenColumns.forEach(function (column) {
                        var cell = row.cells[column];
                        cell.style.display = "";
                    });
                    row.deleteCell(row.cells.length - 1);
                });
            }
            this.hiddenColumns = [];
        },

        /** @type {() => void} */
        redisplayColumns: function () {
            var newHiddenColumns = this.determineHiddenColumns();
            if (newHiddenColumns.length !== this.hiddenColumns.length) {
                this.unhideColumns();
                this.hiddenColumns = newHiddenColumns;
                this.hideColumns();
            }
        },

        /** @type {() => void} */
        collapseDetails: function () {
            array(this.table.querySelectorAll("tr.tablesorter_detail")).forEach(function (row) {
                row.parentNode.removeChild(row);
            });
            array(this.table.querySelectorAll("button.tablesorter_collapse")).forEach(
                function (button) {
                    button.className = "tablesorter_expand";
                    button.textContent = config.show;
                }
            );
        },

        /** @type {() => void} */
        createColumnSelection: function () {
            var self = this;
            /** @type {(heading: Element, index: number) => HTMLLIElement} */
            function makeListItem(heading, index) {
                var li = document.createElement("li");
                var label = document.createElement("label");
                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.value = String(index);
                checkbox.indeterminate = true;
                checkbox.onchange = function () {
                    self.userColumns[index] = checkbox.checked;
                    self.redisplayColumns();
                };
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(" " + heading.textContent));
                li.appendChild(label);
                return li;
            }

            (function () {
                self.headings.forEach(function (heading, index) {
                    var li = makeListItem(heading, index);
                    self.selectionList.appendChild(li);
                });
                self.selectionList.className = "tablesorter_colsel";
                self.selectionList.style.display = "none";

                var columnsButton = document.createElement("button");
                columnsButton.className = "tablesorter_colbutton";
                columnsButton.appendChild(document.createTextNode(config.columns));
                columnsButton.onclick = function () {
                    var style = self.selectionList.style;
                    style.display = style.display === "none" ? "" : "none";
                };
                self.table.parentNode.insertBefore(columnsButton, self.table);
                self.table.parentNode.insertBefore(self.selectionList, self.table);
            })();
        },

        /** @type {(heading: Element, index: number) => void} */
        makeHeadingSortable: function (heading, index) {
            var self = this;
            /** @type {(event: Event) => void} */
            function onSortButtonClick(event) {
                var button = /** @type {HTMLButtonElement} */ (event.currentTarget);
                self.collapseDetails();
                self.headings.forEach(function (heading2) {
                    if (heading2.firstChild !== heading.firstChild) {
                        var button2 = /** @type {HTMLButtonElement} */ (heading2.firstChild);
                        button2.classList.add("tablesorter_asc");
                        button2.classList.add("tablesorter_desc");
                    }
                });
                if (!button.classList.contains("tablesorter_desc")) {
                    button.classList.remove("tablesorter_asc");
                    button.classList.add("tablesorter_desc");
                    self.sort(index, true, heading.classList.contains("tablesorter_numeric"));
                } else {
                    button.classList.remove("tablesorter_desc");
                    button.classList.add("tablesorter_asc");
                    self.sort(index, false, heading.classList.contains("tablesorter_numeric"));
                }
                self.paginate();
            }

            (function () {
                var button = document.createElement("button");
                while (heading.firstChild) {
                    button.appendChild(heading.firstChild);
                }
                heading.appendChild(button);
                button.classList.add("tablesorter_asc");
                button.classList.add("tablesorter_desc");
                button.onclick = onSortButtonClick;
            })();
        },

        /** @type {() => void} */
        init: function () {
            this.hiddenColumns = /** @type {number[]} */ ([]);
            this.headings = array(this.table.querySelectorAll("thead th"));
            this.selectionList = document.createElement("ol");
            this.userColumns = /** @type {boolean[]} */ ([]);
            this.currentPage = 0;
            if (config.sortable) this.headings.forEach(this.makeHeadingSortable.bind(this));
            if (this.table.classList.contains("tablesorter_columns")) {
                this.createColumnSelection();
            }
            var self = this;
            addEventListener("resize", function () {
                self.collapseDetails();
                self.redisplayColumns();
            });
            this.hiddenColumns = this.determineHiddenColumns();
            this.hideColumns();
            this.paginate();
        }
    });

    (function () {
        var meta = /** @type {HTMLMetaElement} */ (
            document.querySelector("meta[name=tablesorter_config]")
        );
        var data = /** @type {string} */ (meta.content);
        config = JSON.parse(data);
        /** @type {HTMLTableElement[]} */ (
            array(document.querySelectorAll("table.tablesorter"))
        ).forEach(function (table) {
            var widget = /** @type {typeof widgetProto} */ (
                Object.create(widgetProto, { table: { value: table } })
            );
            widget.init();
        });
    })();
})();
