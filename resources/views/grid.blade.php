@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-group">
        <select name="ymDate" class="form-control form-control-lg">
            <option>2018-09</option>
            <option>2018-10</option>
            <option>2018-11</option>
            <option>2018-12</option>
            <option>2019-01</option>
            <option>2019-02</option>
        </select>
    </div>
    <table class="table table-bordered list-timereport">
        <tr>
            <th>Check</th>
            <th>
                Date
            </th>
            <th>
                Project
            </th>
            <th>
                Start Time
            </th>
            <th>
                End Time
            </th>
            <th>
                Lunch
            </th>
            <th>
                Leave Recover
            </th>
            <th>
                OT
            </th>
            <th>
                Time Total
            </th>
            <th>
                H
            </th>
            <th>
                I
            </th>
            <th>
                J
            </th>
            <th>
                Remarks
            </th>
        </tr>
        <tr data-uid="1" data-day="1">
            <td class="align-middle">
                <input type="checkbox" name="rowsCheck[]" />
            </td>
            <td class="align-middle">
                01(sep)
            </td>
            <td class="align-middle">
                <select class="form-control" style="width: 150px; height: 32px;">
                    <option value="">Please pick a project up</option>
                    <option value="1" selected>Apple</option>
                    <option value="2">Orange</option>
                    <option value="3">Tomato</option>
                </select>
                <span class="glyphicon glyphicon-plus pointer btnAdd"></span>
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="start_time[]" id="start_time1" />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="end_time[]" id="end_time1" />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center bg-white no-border" name="break_time[]" id="break_time1" readonly />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="leave_recover[]" id="leave_recover1" />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center bg-white no-border" name="overtime[]" id="overtime1" readonly>
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center bg-white no-border" name="time_total[]" id="time_total1" readonly />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="npc_1[]" id="npc_11" />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="npc_2[]" id="npc_21" />
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-center no-border editable" name="npc_3[]" id="npc_31" />
            </td>
            <td class="align-middle">
                <textarea name="remarks[]" id="remarks1" class="no-border h100p w100"></textarea>
            </td>
        </tr>
    </table>
</div>
@endsection

@push('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" />
<style>
    table input {
        width: 100%;
    }
    table th {
        text-align: center;
    }
    table td {
        padding: 2px !important;
        height: 100%;
    }
    .error {
        color: red !important;
    }
    .error-border {
        border: 1px solid red !important;
    }
    .pointer,
    .cursor {
        cursor: pointer;
    }
    .no-border {
        border: 0 !important;
        box-shadow: none !important;
    }
    .w100 {
        width: 100px !important;
    }
    .w100p {
        width: 100% !important;
    }
    .h100p {
        height: 100% !important;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
{{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> --}}
<script>
    // options for the new row generated
    var config = {
        table: '.list-timereport',
        replaceClass: ['span.btnAdd', 'glyphicon-plus btnAdd', 'glyphicon-minus btnRemove'],
        removeCells: [1, 2],
        rowspanCells: [1, 2]
    };
    // options for timepicker
    var optionsTimePicker = {
        maxHours: 24,
        minuteStep: 30,
        defaultTime: '08:30',
        showMeridian: false, // 24hrs mode
    };

    var error = false;

    $(function () {
        // when adding a new row for project
        $(document).on('click', '.btnAdd', function (e) {
            var rowThis = $(this).closest('tr');
            var rowNew  = rowThis.clone();
            setUpRow(rowNew, rowThis, config);
            resetValues(rowNew);
            // insert at end of subrows
            var children = $((config.table || 'table')).find('tr[data-child="'+rowThis.attr('data-uid')+'"]');
            var lastChild = (children.length > 0) ? children[children.length - 1] : rowThis;
            rowNew.insertAfter(lastChild);
        });

        // when removing a row for project
        $(document).on('click', '.btnRemove', function (e) {
            var rowThis = $(this).closest('tr');
            var parentRow = $('tr[data-parent="'+rowThis.attr('data-child')+'"]');
            // update rowspan of parent row
            setRowSpan(parentRow, config, -2); // ignore parent row & row will be removed
            rowThis.remove();
        });

        // when enter values of time inputs, get timepicker for time inputs
        $(document).on('click', 'input.editable', function (e) {
            var self = this;
            optionsTimePicker.defaultTime = getDefaultTime($(this).attr('name'));
            $(this).timepicker(optionsTimePicker).on('hide.timepicker', function (e) { // after timepicker hidden
                // reset input when its value is empty or invalid format or 0
                var inputVal = $(self).val();
                if (inputVal == 0 || // empty
                    /\s*[0]+\s*\:?\s*[0]+\s*/gi.test(e.time.value) || // 0:00, 00:00, 0, 00
                    (isNaN(inputVal) && !/[0-9]{1,2}\:[0-9]{1,2}/gi.test(inputVal)) // non numeric & no hh:ii
                ) { $(self).val(''); }
            });
        });

        // when input changed
        $(document).on('change', 'input.editable', function (e) {
            var timeTotal    = 8;
            var overtime     = 0;
            var totalWorked  = 0;
            var rowThis      = $(this).closest('tr');
            var dateThis     = $('select[name="ymDate"]').val() + '-' + rowThis.attr('data-day');

            var dataChild = rowThis.attr('data-child');
            var dataParent = rowThis.attr('data-parent');
            if ((typeof dataChild !== typeof undefined && dataChild !== false) || (typeof dataParent !== typeof undefined && dataParent !== false)) { // exist
                var et = 0;
                var hasLunch = false;
                var rows = $('table').find('tr[data-day="'+rowThis.attr('data-day')+'"]');
                $.each(rows, function (idx, row) {
                    var cells = getCells($(row));
                    var startTime    = getMiliSeconds(cells.start_time.value, dateThis);
                    var endTime      = getMiliSeconds(cells.end_time.value, dateThis);
                    var leaveRecover = toNumHours(cells.leave_recover.value);

                    if (isNaN(startTime)) {
                        cells.start_time.element.parent('td').addClass('error-border');
                    } else if (isNaN(endTime)) {
                        cells.end_time.element.parent('td').addClass('error-border');
                    } else if (endTime <= startTime) {
                        error = true;
                        cells.start_time.element.parent('td').addClass('error-border');
                    } else {
                        if (startTime < et) {
                            cells.start_time.element.parent('td').addClass('error-border');
                        } else {
                            // show break time (lunch time)
                            if (endTime >= getMiliSeconds('11:30', dateThis) && !hasLunch) {
                                cells.break_time.element.val(1);
                                hasLunch = true;
                            }

                            var total = toNumHours(endTime - startTime);
                            if (totalWorked < 8) {
                                if (total > timeTotal) {
                                    overtime = total - timeTotal;
                                    if (overtime > leaveRecover) {
                                        overtime -= leaveRecover;
                                    } else {
                                        cells.leave_recover.element.val('');
                                    }
                                    cells.overtime.element.val(overtime);
                                } else {
                                    timeTotal = 8 - totalWorked;
                                    //timeTotal = total;
                                    cells.leave_recover.element.val('');
                                    cells.overtime.element.val('');
                                }
                                cells.time_total.element.val(timeTotal);
                            } else {
                                overtime = total;
                                timeTotal = 0;
                                if (overtime > leaveRecover) {
                                    overtime -= leaveRecover;
                                } else {
                                    cells.leave_recover.element.val('');
                                }
                                cells.overtime.element.val(overtime);
                                cells.time_total.element.val('');
                                console.log('overtime: ' + overtime);
                            }
                            totalWorked += timeTotal;
                        }
                    }
                    et = getMiliSeconds(endTime, dateThis);
                    console.log('totalWorked ' + idx + ':' + totalWorked);
                });
            } else {
                var cells        = getCells($(this).closest('tr'));
                //var startTime    = cells.start_time.value;
                //var endTime      = cells.end_time.value;
                //var leaveRecover = cells.leave_recover.value;

                var startTime    = getMiliSeconds(cells.start_time.value, dateThis);
                var endTime      = getMiliSeconds(cells.end_time.value, dateThis);
                var leaveRecover = toNumHours(cells.leave_recover.value);

                if (isNaN(startTime)) {
                    cells.start_time.element.parent('td').addClass('error-border');
                } else if (isNaN(endTime)) {
                    cells.end_time.element.parent('td').addClass('error-border');
                } else if (endTime <= startTime) {
                    error = true;
                    cells.start_time.element.parent('td').addClass('error-border');
                } else {
                    cells.break_time.element.val(1);
                    var total = toNumHours(endTime - startTime);
                    if (total > timeTotal) {
                        overtime = total - timeTotal - leaveRecover;
                    } else {
                        timeTotal = total;
                    }
                    cells.time_total.element.val(timeTotal);
                    cells.overtime.element.val(overtime);
                }
            }
        });
    });

    /**
     * Set up for a row
     *
     * @return void
     */
    function setUpRow(rowNew, rowThis, config) {
        config = config || {};
        rowThis.attr('data-parent', rowThis.attr('data-uid'));
        rowNew.attr('data-child', rowThis.attr('data-uid'));
        rowNew.removeAttr('data-parent');

        // replace classes
        if (config.replaceClass && Array.isArray(config.replaceClass) && config.replaceClass.length === 3) {
            rowNew.find(config.replaceClass[0]).removeClass(config.replaceClass[1]).addClass(config.replaceClass[2]);
        }
        // remove the specified cells
        if (config.removeCells && Array.isArray(config.removeCells)) {
            config.removeCells.forEach(function (v, i) {
                var n = (i === 0) ? v - 1 : v - config.removeCells[i-1] - 1;
                rowNew.find('td:eq('+n+')').remove();
            });
        }
        // set rowspan for the specified columns
        setRowSpan(rowThis, config);
    }

    /**
     * Reset the input values of a row
     *
     * @param HTMLElemt row
     * @return void
     */
    function resetValues(row) {
        if (row) {
            $.each(row.find('td'), function (idx, cell) {
                if ($(cell).find('input').length) { $(cell).find('input').val(''); }
                else if ($(cell).find('select').length) { $(cell).find('select').val(''); }
                else if ($(cell).find('textarea').length) { $(cell).find('textarea').val(''); }
            });
        }
    }

    /**
     * Set 'rowspan' attribute for the specified cells of table
     *
     * @return void
     */
    function setRowSpan(rowThis, config, numRowsIgnored) {
        if (config && config.rowspanCells && Array.isArray(config.rowspanCells)) {
            var rowspan = getRowSpan(rowThis, config.table, numRowsIgnored);
            config.rowspanCells.forEach(function (v, i) {
                if (rowspan == 1) {
                    rowThis.removeAttr('data-parent');
                    rowThis.find('td:eq('+(v-1)+')').removeAttr('rowspan');
                } else {
                    rowThis.find('td:eq('+(v-1)+')').attr('rowspan', rowspan);
                }
            });
        }
    }

    /**
     * Get rowspan from rows generated
     *
     * @param HTMLElement rowThis
     * @param string table
     * @return string
     */
    function getRowSpan(rowThis, table, numRowsIgnored) {
        var rowspan = 2 + (numRowsIgnored || 0); // for this row + a new row
        var parent = rowThis.attr('data-parent');
        if (parent !== undefined && parent !== false) { // any new rows generated?
            var rowsChild = $(table || 'table').find('tr[data-child="'+parent+'"]').length;
            if (rowsChild > 0) { rowspan += rowsChild; }
        }
        return rowspan;
    }

    /**
     * Get default time for timepicker by name of input
     *
     * @param string name
     * @param object inputs
     * @return string
     */
    function getDefaultTime(name, inputs) {
        name = name ? name.replace(/\[\]$/gi, '') : '';
        return (typeof inputs === 'object' && Object.keys(inputs).length ? inputs : {
            end_time: '17:30',
            leave_recover: '00:30'
        })[name] || '08:30';
    }

    function getCells(row, names, options) {
        // options = { start_time: {type: 'input', postfix: '[]'}, }
        var cells = {};
        var names = names || [
            'start_time', 'end_time', 'break_time', 'leave_recover', 'overtime', 'time_total'
        ];
        names.forEach(function (v, i) {
            var tag = 'input';
            var postfix = '[]';
            if (options && typeof options === 'object' && options[v]) {
                tag = options[v]['type'] || tag;
                postfix = options[v]['postfix'] || '';
            }
            var oThis = row.find(tag+'[name="'+v+postfix+'"]');
            cells[v] = {element: oThis, value: oThis.val()};
        });
        return cells;
    }

    function isValidDate(dateStr) {
        return !isNaN((new Date(dateStr)).getTime());
    }

    function isValidTime(timeStr) {
        return !isNaN('1970-01-01 ' + timeStr);
    }

    function getMiliSeconds(timeStr, dateYmdStr) {
        return (new Date((dateYmdStr || getCurrentYmdStr()) + ' ' + timeStr)).getTime();
    }

    function getCurrentYmdStr() {
        var o = new Date();
        return o.getFullYear() + '-' + (o.getMonth() + 1) + '-' + o.getDate();
    }

    function toNumHours(v) {
        // from time string
        if (v && /\s*[0-9]{1,2}\s*\:\s*[0-9]{1,2}\s*/gi.test(v)) {
            var split = v.split(':');
            return Number(split[0]) + Number(split[1])/60;
        }
        // from miliseconds (numeric)
        if (!isNaN(v)) {
            return v/(1000*60*60) - 1;
        }
        return 0;
    }

    function updateRows() {

    }
</script>
@endpush
