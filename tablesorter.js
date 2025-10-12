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
    var config = (function () {
        var meta = /** @type {HTMLMetaElement} */ (
            document.querySelector("meta[name=tablesorter_config]")
        );
        var data = /** @type {string} */ (meta.content);
        return JSON.parse(data);
    })();

    /** @type {(table: HTMLTableElement) => void} */
    function initWidget(table) {
        var hiddenColumns = /** @type {number[]} */ ([]);
        var headings = array(table.querySelectorAll("thead th"));
        var selectionList = document.createElement("ol");
        var userColumns = /** @type {boolean[]} */ ([]);

        /** @type {() => void} */
        function paginate() {
            var currentPage = 0;
            collapseDetails();
            var rows = table.tBodies[0].rows;
            var pageCount = Math.ceil(rows.length / config.maxPages);
            var start = currentPage * config.maxPages;
            var end = (currentPage + 1) * config.maxPages - 1;
            array(rows).forEach(function (row, index) {
                if (index >= start && index <= end) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
            if (pageCount > 1) {
                var pagination = document.createElement("div");
                pagination.className = "tablesorter_pagination";
                /** @type {number[]} */ (
                    Array.apply(undefined, Array(pageCount)).map(Number.call, Number)
                ).forEach(function (index) {
                    var button = document.createElement("button");
                    button.textContent = String(index + 1);
                    if (index === currentPage) {
                        button.disabled = true;
                    }
                    button.onclick = function () {
                        currentPage = index;
                        paginate();
                    };
                    pagination.appendChild(button);
                });
                if (
                    table.nextElementSibling &&
                    table.nextElementSibling.classList.contains("tablesorter_pagination")
                ) {
                    table.nextElementSibling.parentNode.removeChild(table.nextElementSibling);
                }
                table.parentNode.insertBefore(pagination, table.nextElementSibling);
            }
        }

        /** @type {(column: number, desc: boolean, numeric: boolean) => void} */
        function sort(column, desc, numeric) {
            var tbody = table.tBodies[0];
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
        }

        /** @type {() => number[]} */
        function determineHiddenColumns() {
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
            headings.forEach(function (heading, index) {
                if (userColumns[index] !== undefined) {
                    if (!userColumns[index]) {
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
        }

        /** @type {() => void} */
        function hideColumns() {
            if (hiddenColumns.length) {
                array(table.querySelectorAll("tr")).forEach(function (row) {
                    hiddenColumns.forEach(function (column) {
                        var cell = row.cells[column];
                        cell.style.display = "none";
                    });
                    row.insertCell();
                    if (row.parentElement && row.parentElement.nodeName.toLowerCase() === "tbody") {
                        var section = /** @type {HTMLTableSectionElement} */ (row.parentElement);
                        var button = document.createElement("button");
                        button.className = "tablesorter_expand";
                        button.textContent = config.show;
                        button.onclick = function () {
                            if (button.className === "tablesorter_expand") {
                                var detailRow = section.insertRow(row.sectionRowIndex + 1);
                                detailRow.className = "tablesorter_detail";
                                var detailCell = detailRow.insertCell();
                                detailCell.colSpan = row.cells.length;
                                var defList = document.createElement("dl");
                                hiddenColumns.forEach(function (column) {
                                    var dt = document.createElement("dt");
                                    var headingElement = headings[column];
                                    if (config.sortable) {
                                        headingElement = /** @type {HTMLButtonElement} */ (
                                            headingElement.firstChild
                                        );
                                    }
                                    dt.innerHTML = headingElement.innerHTML;
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
                        };
                        var lastCell = row.cells[row.cells.length - 1];
                        lastCell.insertBefore(button, lastCell.firstElementChild);
                    }
                });
                var checkboxes = /** @type {HTMLInputElement[]} */ (
                    array(selectionList.querySelectorAll("input[type=checkbox]"))
                );
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = hiddenColumns.indexOf(Number(checkbox.value)) < 0;
                });
            }
        }

        /** @type {() => void} */
        function unhideColumns() {
            if (hiddenColumns.length) {
                array(table.querySelectorAll("tr")).forEach(function (row) {
                    hiddenColumns.forEach(function (column) {
                        var cell = row.cells[column];
                        cell.style.display = "";
                    });
                    row.deleteCell(row.cells.length - 1);
                });
            }
            hiddenColumns = [];
        }

        /** @type {() => void} */
        function redisplayColumns() {
            var newHiddenColumns = determineHiddenColumns();
            if (newHiddenColumns.length !== hiddenColumns.length) {
                unhideColumns();
                hiddenColumns = newHiddenColumns;
                hideColumns();
            }
        }

        /** @type {() => void} */
        function collapseDetails() {
            array(table.querySelectorAll("tr.tablesorter_detail")).forEach(function (row) {
                row.parentNode.removeChild(row);
            });
            array(table.querySelectorAll("button.tablesorter_collapse")).forEach(function (button) {
                button.className = "tablesorter_expand";
                button.textContent = config.show;
            });
        }

        /** @type {() => void} */
        function createColumnSelection() {
            headings.forEach(function (heading, index) {
                var li = document.createElement("li");
                var label = document.createElement("label");
                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.value = String(index);
                checkbox.indeterminate = true;
                checkbox.onchange = function () {
                    userColumns[index] = checkbox.checked;
                    redisplayColumns();
                };
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(" " + heading.textContent));
                li.appendChild(label);
                selectionList.appendChild(li);
            });
            selectionList.className = "tablesorter_colsel";
            selectionList.style.display = "none";

            var columnsButton = document.createElement("button");
            columnsButton.className = "tablesorter_colbutton";
            columnsButton.appendChild(document.createTextNode(config.columns));
            columnsButton.onclick = function () {
                selectionList.style.display = selectionList.style.display === "none" ? "" : "none";
            };
            table.parentNode.insertBefore(columnsButton, table);
            table.parentNode.insertBefore(selectionList, table);
        }

        headings.forEach(function (heading, index) {
            if (!config.sortable) {
                return;
            }
            var button = document.createElement("button");
            while (heading.firstChild) {
                button.appendChild(heading.firstChild);
            }
            heading.appendChild(button);
            button.classList.add("tablesorter_asc", "tablesorter_desc");
            button.onclick = function () {
                collapseDetails();
                headings.forEach(function (heading2) {
                    if (heading2.firstChild !== heading.firstChild) {
                        var button2 = /** @type {HTMLButtonElement} */ (heading2.firstChild);
                        button2.classList.add("tablesorter_asc", "tablesorter_desc");
                    }
                });
                if (!button.classList.contains("tablesorter_desc")) {
                    button.classList.remove("tablesorter_asc");
                    button.classList.add("tablesorter_desc");
                    sort(index, true, heading.classList.contains("tablesorter_numeric"));
                } else {
                    button.classList.remove("tablesorter_desc");
                    button.classList.add("tablesorter_asc");
                    sort(index, false, heading.classList.contains("tablesorter_numeric"));
                }
                paginate();
            };
        });
        if (table.classList.contains("tablesorter_columns")) {
            createColumnSelection();
        }
        addEventListener("resize", function () {
            collapseDetails();
            redisplayColumns();
        });
        hiddenColumns = determineHiddenColumns();
        hideColumns();
        paginate();
    }

    /** @type {HTMLTableElement[]} */ (
        array(document.querySelectorAll("table.tablesorter"))
    ).forEach(initWidget);
})();
