@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <select name="ymDate" class="form-control-lg">
            <option>Please pick a date up...</option>
            <option>2018-09</option>
            <option>2018-10</option>
            <option>2018-11</option>
            <option>2018-12</option>
            <option>2019-01</option>
            <option>2019-02</option>
        </select>
        <select name="ymDate" class="form-control-lg">
            <option>Please pick a project up...</option>
            <option value="1">Project A</option>
            <option value="2">Project B</option>
            <option value="3">Project C</option>
            <option value="4">Project D</option>
        </select>
    </div>
    <br>
    <div class="row">
        <table class="table table-bordered list-timereport">
            <head>
            <tr>
                <th class="align-middle">Check</th>
                <th class="align-middle">
                    Status
                </th>
                <th class="align-middle">
                    Date
                </th>
                <th class="align-middle">
                    Work Status
                </th>
                <th class="align-middle">
                    Work Style
                </th>
                <th class="align-middle">
                    Project
                </th>
                <th class="align-middle">
                    Start Time
                </th>
                <th class="align-middle">
                    End Time
                </th>
                <th class="align-middle">
                    Lunch Time
                </th>
                <th class="align-middle">
                    Small Leave
                </th>
                <th class="align-middle">
                    Leave Recovery
                </th>
                <th class="align-middle">
                    Overtime
                </th>
                <th class="align-middle">
                    Midnight
                </th>
                <th class="align-middle">
                    Total Time
                </th>
                <th class="align-middle">
                    NPC Regular Time
                </th>
                <th class="align-middle">
                    NPC Overtime
                </th>
                <th class="align-middle">
                    NPC Midnight
                </th>
                <th class="align-middle">
                    Remarks
                </th>
            </tr>
            </head>
            <tr data-index="1" data-uid="1" data-day="2018-09-01">
                <td class="align-middle">
                    <input type="checkbox" name="checkList[]" />
                </td>
                <td class="align-middle">
                    Waiting
                </td>
                <td class="align-middle">
                    01(sep)
                </td>
                <td class="align-middle">
                    <select class="form-control" name="mst_work_statuses_id[]" style="width: 100px; height: 32px;">
                        <option value="">Select One...</option>
                        <option value="1">Public</option>
                        <option value="2">Holiday</option>
                        <option value="3">Weekend</option>
                        <option value="4" selected>Working</option>
                    </select>
                </td>
                <td class="align-middle">
                    <select class="form-control" name="mst_work_styles_id[]" style="width: 100px; height: 32px;">
                        <option value="">Select One...</option>
                        <option value="1" selected>Full Time</option>
                        <option value="2">Part Time</option>
                        <option value="3">Baby Care</option>
                    </select>
                </td>
                <td class="align-middle">
                    <select class="form-control" name="mst_project_id[]" style="width: 100px; height: 32px;">
                        <option value="">Select One...</option>
                        <option value="1" selected>Project A</option>
                        <option value="2">Project B</option>
                        <option value="3">Project C</option>
                    </select>
                    <span class="glyphicon glyphicon-plus pointer btnAdd"></span>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="start_time[]" />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="end_time[]" />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center bg-white no-border" name="break_time[]" readonly />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center bg-white no-border" name="small_leave[]" readonly />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="leave_recovery[]" />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center bg-white no-border" name="overtime[]" readonly>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center bg-white no-border" name="midnight[]" readonly>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center bg-white no-border" name="total_time[]" readonly />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="npc_regular_time[]" />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="npc_overtime[]" />
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-center no-border editable" name="npc_midnight[]" />
                </td>
                <td class="align-middle">
                    <textarea name="remarks[]" class="no-border h100p w100"></textarea>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" />
<style>
    table.list-timereport,
    table.list-timereport select {
        font-size: 9px;
    }
    table input {
        width: 100%;
    }
    table th {
        text-align: center !important;
    }
    table td {
        padding: 2px !important;
        height: 100%;
        text-align: center;
    }
    table td .form-control {
        padding: 6px 4px;
    }
    .ui-timepicker-standard .ui-timepicker {
        font-size: 10px !important;
        font-weight: bold;
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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    // options for the new row generated
    var config = {
        table: '.list-timereport',
        replaceClass: ['span.btnAdd', 'glyphicon-plus btnAdd', 'glyphicon-minus btnRemove'],
        removeCells: [1, 2, 3, 4, 5],
        rowspanCells: [1, 2, 3, 4, 5]
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
            $(this).timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '00:00',
                maxTime: '23:00',
                defaultTime: getDefaultTime($(self).attr('name')),
                startTime: '00:00',
                dynamic: false,
                dropdown: true,
                scrollbar: false,
                change: function (time) {
                    if (time === false) {
                        $(self).val('');
                        return;
                    }
                    console.log(time);

                    var totalTime    = 8;
                    var overtime     = 0;
                    var totalWorked  = 0;
                    var rowThis      = $(self).closest('tr');
                    var dateThis     = $('select[name="ymDate"]').val() + '-' + rowThis.attr('data-day');

                    var dataChild = rowThis.attr('data-child');
                    var dataParent = rowThis.attr('data-parent');

                    if ((typeof dataChild !== typeof undefined && dataChild !== false) || (typeof dataParent !== typeof undefined && dataParent !== false)) { // exist
                        var et = 0;
                        var hasLunch = false;
                        var rows = $('table').find('tr[data-day="'+rowThis.attr('data-day')+'"]');
                        $.each(rows, function (idx, row) {
                            calculateRelation($(row));
                            // var cells = getCells($(row));
                            // var startTime    = getMiliSeconds(cells.start_time.value, dateThis);
                            // var endTime      = getMiliSeconds(cells.end_time.value, dateThis);
                            // var leaveRecovery = toNumHours(cells.leave_recovery.value);

                            // if (isNaN(startTime)) {
                            //     cells.start_time.element.parent('td').addClass('error-border');
                            // } else if (isNaN(endTime)) {
                            //     cells.end_time.element.parent('td').addClass('error-border');
                            // } else if (endTime <= startTime) {
                            //     error = true;
                            //     cells.start_time.element.parent('td').addClass('error-border');
                            // } else {
                            //     if (startTime < et) {
                            //         cells.start_time.element.parent('td').addClass('error-border');
                            //     } else {
                            //         // show break time (lunch time)
                            //         if (endTime >= getMiliSeconds('11:30', dateThis) && !hasLunch) {
                            //             cells.break_time.element.val(1);
                            //             hasLunch = true;
                            //         }

                            //         var total = toNumHours(endTime - startTime, -1);
                            //         if (totalWorked < 8) {
                            //             if (total > totalTime) {
                            //                 overtime = total - totalTime;
                            //                 if (overtime > leaveRecovery) {
                            //                     overtime -= leaveRecovery;
                            //                 } else {
                            //                     cells.leave_recovery.element.val('');
                            //                 }
                            //                 cells.overtime.element.val(overtime);
                            //             } else {
                            //                 totalTime = 8 - totalWorked;
                            //                 //timeTotal = total;
                            //                 cells.leave_recovery.element.val('');
                            //                 cells.overtime.element.val('');
                            //             }
                            //             cells.total_time.element.val(totalTime);
                            //         } else {
                            //             overtime = total;
                            //             totalTime = 0;
                            //             if (overtime > leaveRecovery) {
                            //                 overtime -= leaveRecovery;
                            //             } else {
                            //                 cells.leave_recovery.element.val('');
                            //             }
                            //             cells.overtime.element.val(overtime);
                            //             cells.total_time.element.val('');
                            //             console.log('overtime: ' + overtime);
                            //         }
                            //         totalWorked += totalTime;
                            //     }
                            // }
                            // et = getMiliSeconds(endTime, dateThis);
                            // console.log('totalWorked ' + idx + ':' + totalWorked);
                        });
                    } else {
                        if (calculate(rowThis) === false && ['start_time[]', 'end_time[]'].indexOf($(self).attr('name')) === -1) {
                            $(self).val('');
                            calculate(rowThis);
                        }
                    }
                }
            });
        });

        // when input changed
        // $(document).on('change', 'input.editable', function (e) {
        // });
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
            start_time: '08:30',
            end_time: '17:30',
            leave_recovery: '00:30',
            npc_regular_time: '00:30',
            npc_overtime: '00:30',
            npc_midnight: '00:30'
        })[name] || '';
    }

    function getCells(row, names, options) {
        // options = { start_time: {type: 'input', postfix: '[]'}, }
        var cells = {};
        var names = names || [
            'start_time', 'end_time', 'break_time', 'small_leave', 'leave_recovery', 'overtime',
            'midnight', 'total_time', 'npc_regular_time', 'npc_overtime', 'npc_midnight', 'remarks'
        ];
        names.forEach(function (v, i) {
            var tag = 'input';
            var postfix = '[]';
            if (options && typeof options === 'object' && options[v]) {
                tag = options[v]['type'] || tag;
                postfix = options[v]['postfix'] || '';
            }
            var oThis = row.find(tag+'[name="'+v+postfix+'"]');
            cells[v] = {element: oThis, value: oThis.val(), value_number: toNumHours(oThis.val())};
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

    function toNumHours(v, addsub) {
        if (typeof addsub !== 'number') {
            addsub = 0;
        }
        // from time string
        if (v && /\s*[0-9]{1,2}\s*\:\s*[0-9]{1,2}\s*/.test(v)) {
            var split = v.split(':');
            return Number(split[0]) + Number(split[1])/60 + addsub;
        }
        // from miliseconds (numeric)
        if (!isNaN(v) && parseFloat(v) == v) {
            return Number(v)/(1000*60*60) + addsub;
        }
        return 0;
    }

    function toRangeNumHours(rangeHours) {
        if (Array.isArray(rangeHours) && rangeHours.length === 2) {
            var first = rangeHours[0].toString().replace(' ', '');
            var second = rangeHours[1].toString().replace(' ', '');

            var pattern = /[0-9]{1,2}\:[0-9]{1,2}/;
            if (pattern.test(first) && pattern.test(second)) {
                first = toNumHours(first);
                second = toNumHours(second);
                if (first <= second) {
                    return [first, second];
                }
                return [first, 24 + second - 1] // 1: lunch time
            }
            throw new Error('Time format must be hh:mm.');
        }
        throw new Error('It must be an array with only 2 elements.');
    }

    function updateRows() {

    }

    function calculateRelation(row) {
        var rangeRegularTime = toRangeNumHours(['08:30', '17:30']); // [8.5, 17.5] - 1 (lunch)
        var rangeOverTime    = toRangeNumHours(['17:30', '22:30']); // [17.5, 22.50]
        var rangeMidNight    = toRangeNumHours(['22:30', '06:30']); // [22.5, 29.5]22.5 + 1.5 + 6.5 -1 (lunch)
        var minStartTime     = toNumHours('08:30');
        var maxStartTime     = toNumHours('24:00');
        var minEndTime       = toNumHours('08:30');
        var maxEndTime       = toNumHours('24:00');
        var lunchTime        = toNumHours('11:30');

        var cells          = getCells(row);
        var startTime      = cells.start_time.value_number;
        var endTime        = cells.end_time.value_number;
        var breakTime      = 0;
        var smallLeave     = cells.small_leave.value_number;
        var leaveRecovery  = cells.leave_recovery.value_number;
        var overtime       = cells.overtime.value_number;
        var midnight       = cells.midnight.value_number;
        var totalTime      = cells.total_time.value_number;
        var npcRegularTime = cells.npc_regular_time.value_number;
        var npcOverTime    = cells.npc_overtime.value_number;
        var npcMidNight    = cells.npc_midnight.value_number;
        var remarks        = cells.remarks.value_number;

        var workTime = 8;
        var flag = false;

        if (startTime == 0 && endTime == 0) {
            resetValues(row);
            flag = true;
            console.log(1);
            return false;
        }

        if (startTime < minStartTime || startTime > maxStartTime) {
            toggleErrorCell(cells, 'start_time');
            flag = true;
            console.log(2);
            return false;
        }

        if (endTime < minEndTime || endTime > maxEndTime) {
            toggleErrorCell(cells, 'end_time');
            flag = true;
            console.log(3);
            return false;
        }

        if (startTime > endTime) {
            toggleErrorCell(cells, 'start_time');
            flag = true;
            console.log(4);
            return false;
        }

        toggleErrorCell(cells, ['start_time', 'end_time'], true);

        if (endTime <= rangeRegularTime[1]) { // in regular time
            breakTime  = endTime >= lunchTime ? 1 : 0;
            totalTime  = endTime - startTime - breakTime;
            smallLeave = workTime - totalTime;
            totalTime  = totalTime - npcRegularTime;

            // check npc regular time
            if (totalTime < 0) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // show
            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val(normalize(smallLeave));
            cells.leave_recovery.element.val('');
            cells.overtime.element.val('');
            cells.midnight.element.val('');
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val('');
            cells.npc_midnight.element.val('');
            console.log('Regular Time');
        } else if (endTime <= rangeOverTime[1]) { // in overtime
            breakTime = 1;
            totalTime = endTime - rangeRegularTime[0] - breakTime;

            // check npc regular time
            totalTime = totalTime - npcRegularTime;
            if (totalTime < 0 || totalTime < workTime) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // check leave recovery
            totalTime = totalTime - leaveRecovery;
            if (totalTime < 0 || (leaveRecovery > 0 && totalTime < workTime)) {
                toggleErrorCell(cells, 'leave_recovery');
                return false;
            }
            toggleErrorCell(cells, 'leave_recovery', true);

            // check overtime
            if (totalTime >= workTime) {
                overtime = totalTime - workTime;
                totalTime = workTime;
            }

            // check npc overtime
            if (npcOverTime > 0 && npcOverTime <= overtime) {
                overtime = overtime - npcOverTime;
            } else if (npcOverTime > overtime) {
                toggleErrorCell(cells, 'npc_overtime');
                return false;
            }
            toggleErrorCell(cells, 'npc_overtime', true);

            // show
            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val('');
            cells.leave_recovery.element.val(toHHMM(leaveRecovery));
            cells.overtime.element.val(normalize(overtime));
            cells.midnight.element.val('');
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val(toHHMM(npcOverTime));
            cells.npc_midnight.element.val('');
            console.log('OverTime');
        } else if (endTime <= rangeMidNight[1]) { //in midnight
            breakTime = 1;
            totalTime = endTime - rangeRegularTime[0] - breakTime;

            // check npc regular time
            totalTime = totalTime - npcRegularTime;
            if (totalTime < 0 || totalTime < workTime) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // check leave recovery
            totalTime = totalTime - leaveRecovery;
            if (totalTime < 0 || (leaveRecovery > 0 && totalTime < workTime)) {
                toggleErrorCell(cells, 'leave_recovery');
                return false;
            }
            toggleErrorCell(cells, 'leave_recovery', true);

            // check overtime
            if (totalTime >= workTime) {
                overtime = totalTime - workTime;
                totalTime = workTime;
            }

            // check npc overtime
            if (npcOverTime > 0 && npcOverTime <= overtime) {
                overtime = overtime - npcOverTime;
            } else if (npcOverTime > overtime) {
                toggleErrorCell(cells, 'npc_overtime');
                return false;
            }
            toggleErrorCell(cells, 'npc_overtime', true);

            // check npc midnight
            midnight = endTime - rangeMidNight[0];
            if (npcMidNight > 0 && npcMidNight <= midnight) {
                midnight = midnight - npcMidNight;
            } else if (npcMidNight > midnight) {
                toggleErrorCell(cells, 'npc_midnight');
                return false;
            }
            toggleErrorCell(cells, 'npc_midnight', true);

            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val('');
            cells.leave_recovery.element.val(toHHMM(leaveRecovery));
            cells.overtime.element.val(normalize(overtime));
            cells.midnight.element.val(normalize(midnight));
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val(toHHMM(npcOverTime));
            cells.npc_midnight.element.val(toHHMM(npcMidNight));
            console.log('MidNight');
        }
    }

    function calculate(row) {
        var rangeRegularTime = toRangeNumHours(['08:30', '17:30']); // [8.5, 17.5] - 1 (lunch)
        var rangeOverTime    = toRangeNumHours(['17:30', '22:30']); // [17.5, 22.50]
        var rangeMidNight    = toRangeNumHours(['22:30', '06:30']); // [22.5, 29.5]22.5 + 1.5 + 6.5 -1 (lunch)
        var minStartTime     = toNumHours('08:30');
        var maxStartTime     = toNumHours('24:00');
        var minEndTime       = toNumHours('08:30');
        var maxEndTime       = toNumHours('24:00');
        var lunchTime        = toNumHours('11:30');

        var cells          = getCells(row);
        var startTime      = cells.start_time.value_number;
        var endTime        = cells.end_time.value_number;
        var breakTime      = 0;
        var smallLeave     = cells.small_leave.value_number;
        var leaveRecovery  = cells.leave_recovery.value_number;
        var overtime       = cells.overtime.value_number;
        var midnight       = cells.midnight.value_number;
        var totalTime      = cells.total_time.value_number;
        var npcRegularTime = cells.npc_regular_time.value_number;
        var npcOverTime    = cells.npc_overtime.value_number;
        var npcMidNight    = cells.npc_midnight.value_number;
        var remarks        = cells.remarks.value_number;

        var workTime = 8;
        var flag = false;

        if (startTime == 0 && endTime == 0) {
            resetValues(row);
            flag = true;
            console.log(1);
            return false;
        }

        if (startTime < minStartTime || startTime > maxStartTime) {
            toggleErrorCell(cells, 'start_time');
            flag = true;
            console.log(2);
            return false;
        }

        if (endTime < minEndTime || endTime > maxEndTime) {
            toggleErrorCell(cells, 'end_time');
            flag = true;
            console.log(3);
            return false;
        }

        if (startTime > endTime) {
            toggleErrorCell(cells, 'start_time');
            flag = true;
            console.log(4);
            return false;
        }

        toggleErrorCell(cells, ['start_time', 'end_time'], true);

        if (endTime <= rangeRegularTime[1]) { // in regular time
            breakTime  = endTime >= lunchTime ? 1 : 0;
            totalTime  = endTime - startTime - breakTime;
            smallLeave = workTime - totalTime;
            totalTime  = totalTime - npcRegularTime;

            // check npc regular time
            if (totalTime < 0) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // show
            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val(normalize(smallLeave));
            cells.leave_recovery.element.val('');
            cells.overtime.element.val('');
            cells.midnight.element.val('');
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val('');
            cells.npc_midnight.element.val('');
            console.log('Regular Time');
        } else if (endTime <= rangeOverTime[1]) { // in overtime
            breakTime = 1;
            totalTime = endTime - rangeRegularTime[0] - breakTime;

            // check npc regular time
            totalTime = totalTime - npcRegularTime;
            if (totalTime < 0 || totalTime < workTime) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // check leave recovery
            totalTime = totalTime - leaveRecovery;
            if (totalTime < 0 || (leaveRecovery > 0 && totalTime < workTime)) {
                toggleErrorCell(cells, 'leave_recovery');
                return false;
            }
            toggleErrorCell(cells, 'leave_recovery', true);

            // check overtime
            if (totalTime >= workTime) {
                overtime = totalTime - workTime;
                totalTime = workTime;
            }

            // check npc overtime
            if (npcOverTime > 0 && npcOverTime <= overtime) {
                overtime = overtime - npcOverTime;
            } else if (npcOverTime > overtime) {
                toggleErrorCell(cells, 'npc_overtime');
                return false;
            }
            toggleErrorCell(cells, 'npc_overtime', true);

            // show
            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val('');
            cells.leave_recovery.element.val(toHHMM(leaveRecovery));
            cells.overtime.element.val(normalize(overtime));
            cells.midnight.element.val('');
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val(toHHMM(npcOverTime));
            cells.npc_midnight.element.val('');
            console.log('OverTime');
        } else if (endTime <= rangeMidNight[1]) { //in midnight
            breakTime = 1;
            totalTime = endTime - rangeRegularTime[0] - breakTime;

            // check npc regular time
            totalTime = totalTime - npcRegularTime;
            if (totalTime < 0 || totalTime < workTime) {
                toggleErrorCell(cells, 'npc_regular_time');
                return false;
            }
            toggleErrorCell(cells, 'npc_regular_time', true);

            // check leave recovery
            totalTime = totalTime - leaveRecovery;
            if (totalTime < 0 || (leaveRecovery > 0 && totalTime < workTime)) {
                toggleErrorCell(cells, 'leave_recovery');
                return false;
            }
            toggleErrorCell(cells, 'leave_recovery', true);

            // check overtime
            if (totalTime >= workTime) {
                overtime = totalTime - workTime;
                totalTime = workTime;
            }

            // check npc overtime
            if (npcOverTime > 0 && npcOverTime <= overtime) {
                overtime = overtime - npcOverTime;
            } else if (npcOverTime > overtime) {
                toggleErrorCell(cells, 'npc_overtime');
                return false;
            }
            toggleErrorCell(cells, 'npc_overtime', true);

            // check npc midnight
            midnight = endTime - rangeMidNight[0];
            if (npcMidNight > 0 && npcMidNight <= midnight) {
                midnight = midnight - npcMidNight;
            } else if (npcMidNight > midnight) {
                toggleErrorCell(cells, 'npc_midnight');
                return false;
            }
            toggleErrorCell(cells, 'npc_midnight', true);

            cells.break_time.element.val(normalize(breakTime));
            cells.small_leave.element.val('');
            cells.leave_recovery.element.val(toHHMM(leaveRecovery));
            cells.overtime.element.val(normalize(overtime));
            cells.midnight.element.val(normalize(midnight));
            cells.total_time.element.val(normalize(totalTime));
            cells.npc_regular_time.element.val(toHHMM(npcRegularTime));
            cells.npc_overtime.element.val(toHHMM(npcOverTime));
            cells.npc_midnight.element.val(toHHMM(npcMidNight));
            console.log('MidNight');
        }
    }

    function toggleErrorCell(cells, inputName, flag) {
        flag = typeof flag === 'boolean' ? flag : false;
        if (typeof inputName === 'string') {
                inputName = [inputName];
        }
        if (Array.isArray(inputName)) {
            inputName.forEach(function (name) {
                if (cells.hasOwnProperty(name)) {
                    flag ? cells[name].element.closest('td').removeClass('error-border')
                         : cells[name].element.closest('td').addClass('error-border');
                };
            });
        }
    }

    function normalize(value, defaultText) {
        return value ? value : (typeof defaultText !== 'undefined' ? defaultText : '');
    }

    function pad2LeftZero(num) {
        return !isNaN(num) && parseFloat(num) == num ? (Number(num) < 10 ? '0'+num : num+'') : '';
    }

    function toHHMM(numHours) {
        return !isNaN(numHours) && parseFloat(numHours) == numHours && Number(numHours) !== 0
            ? pad2LeftZero(Number(numHours) - Number(numHours)%1) + ':' + pad2LeftZero((Number(numHours)%1)*60)
            : '';
    }
</script>
@endpush
