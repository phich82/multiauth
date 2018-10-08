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
        <button class="btn btn-primary btn-sm" name="btnSave" onclick="submitTimeSheet()">Save</button>
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
            <tr data-index="1" data-id="1" data-uid="1" data-day="2018-09-01">
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
        totalLunch: 1,
        textDefault: '',
        postfix: '[]',
        replaceClass: [
            ['.span-add-new-project i', 'fa-plus', 'fa-minus-circle'],
            ['.span-add-new-project', 'span-add-new-project', 'span-remove-project'],
        ],
        replaceText: [
            ['.span-add-new-project span', 'remove this'],
        ],
        removeCells: [1, 2, 3, 4, 5],
        rowspanCells: [1, 2, 3, 4, 5]
    };

    var trackRecordsRemoved = [];
    var types = {old: 0, insert: 1, update: 2, delete: 3};
    var trackRowsChecked = {insert: {}, update: {}};
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

            // update time sheet
            var dataChild  = rowThis.attr('data-child');
            var dataParent = rowThis.attr('data-parent')
            if ((typeof dataChild !== typeof undefined && dataChild !== false) || (typeof dataParent !== typeof undefined && dataParent !== false)) {
                var rows = $(config.table || 'table').find('tr[data-day="'+rowThis.attr('data-day')+'"]');
                calculateRelation(rows);
            }
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

                    var rowThis    = $(self).closest('tr');
                    var dataChild  = rowThis.attr('data-child');
                    var dataParent = rowThis.attr('data-parent');

                    // remove the error messages if exists
                    rowThis.find('.error-border').removeClass('error-border');
                    $('#result-message').html('').hide();

                    if ((typeof dataChild !== typeof undefined && dataChild !== false) || (typeof dataParent !== typeof undefined && dataParent !== false)) { // exist
                        var rows = $(config.table || 'table').find('tr[data-day="'+rowThis.attr('data-day')+'"]');
                        if (calculateRelation(rows) === false && ['start_time[]', 'end_time[]'].indexOf($(self).attr('name')) === -1) {
                            $(self).val(config.textDefault);
                            calculateRelation(rows);
                        }
                    } else {
                        if (calculate(rowThis) === false && ['start_time[]', 'end_time[]'].indexOf($(self).attr('name')) === -1) {
                            $(self).val(config.textDefault);
                            calculate(rowThis);
                        }
                        updateFlag(rowThis, 'update');
                    }
                }
            });
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

    function getRowsChecked(table, name, postfix) {
        var out = [];
        if (table) {
            var elementsChecked = $(table).find('tr input['+(name ? 'name="'+name+(postfix || '')+'"' : 'type="checkbox"')+']:checked');
            if (elementsChecked.length > 0) {
                var out = [];
                $.each(elementsChecked, function (idx, element) {
                    out.push(Number($(element).closest('tr').attr('data-index')));
                });
            }
        }
        return out;
    }

    /**
     * Get the value of the given input
     *
     * @author phat.nguyen@persol.co.jp
     *
     * @param mixed identity
     * @param string name
     * @param string postfix
     * @return mixed
     */
    function getInputVal(identity, name, postfix) {
        if (typeof identity === 'object') { // object
            return $(identity).find('input[name="' + name + (postfix || '') + '"]').val();
        }
        if (!isNaN(identity) && parseFloat(identity) == identity) { // numeric
            identity = 'input[name="' + name + identity + (postfix || '') + '"]';
        }
        return $(identity).val();
    }

    /**
     * Get the value of the given select
     *
     * @author phat.nguyen@persol.co.jp
     *
     * @param mixed identity
     * @param string name
     * @param string postfix
     * @return mixed
     */
    function getSelectVal(identity, name, postfix) {
        if (typeof identity === 'object') { // object
            return $(identity).find('select[name="' + name + (postfix || '') + '"]').val();
        }
        if (!isNaN(identity) && parseFloat(identity) == identity) { // numeric
            identity = 'select[name="' + name + identity + (postfix || '') + '"]';
        }
        return $(identity).val();
    }

    /**
     * Get the value of the given textarea
     *
     * @author phat.nguyen@persol.co.jp
     *
     * @param mixed identity
     * @param string name
     * @param string postfix
     * @return mixed
     */
    function getTextAreaVal(identity, name, postfix) {
        if (typeof identity === 'object') { // object
            return $(identity).find('textarea[name="' + name + (postfix || '') + '"]').val();
        }
        if (!isNaN(identity) && parseFloat(identity) == identity) { // numeric
            identity = 'textarea[name="' + name + identity + (postfix || '') + '"]';
        }
        return $(identity).val();
    }

    function updateFlag(row, action) {
        if (row && $(row)) {
            var id = $(row).attr('data-id');
            var types = {old: 0, insert: 1, update: 2, delete: 3};
            if (id && isInt(id) && parseInt(id) > 0) {
                $(row).attr('data-flag', types[action]);
            } else {
                $(row).attr('data-flag', types.insert);
            }
        }
    }

    function submitTimeSheet(submitUrl) {
        $('.success_action').remove();
        let checkedRow = getRowsChecked(config.table);
        if (checkedRow.length <= 0) {
            alert('Please select at least one row');
            return;
        }
        trackRowsChecked = {insert: {}, update: {}};
        var reportData = {
            insert: [],
            update: [],
            remove: trackRecordsRemoved,
            track: {
                insert: {},
                update: {}
            }
        };
        var tableThis = $(config.table || 'table');

        for (let i = 0; i < checkedRow.length; i++) {
            var rowThis = tableThis.find('tr[data-index="'+checkedRow[i]+'"]');
            var reportDate = rowThis.attr('data-day');
            var rows = tableThis.find('tr[data-day="'+reportDate+'"]');

            $.each(rows, function (idx, row) {
                var id   = $(row).attr('data-id');
                var flag = $(row).attr('data-flag');
                var uid  = $(row).attr('data-parent') == 0 || $(row).attr('data-child') == 0 ? 0 : ($(row).attr('data-parent') || $(row).attr('data-child') || $(row).attr('data-uid'));
                var mstWorkStatusesId = tableThis.find('tr[data-uid="'+Number(uid)+'"] select[name="mst_work_statuses_id[]"]').val();
                var mstWorkStylesId   = tableThis.find('tr[data-uid="'+Number(uid)+'"] select[name="mst_work_styles_id[]"]').val();
                var startTime = getInputVal(row, 'start_time', config.postfix);
                var endTime = getInputVal(row, 'end_time', config.postfix);

                console.log('start time '+ idx + ': ' + startTime);
                console.log('end time '  + idx + ': ' + endTime);
                // validate rows
                if (rows.length > 1) {
                    if (calculateRelation(rows) === false) {
                        return false;
                    }
                } else {
                    if (calculate($(row)) === false) {
                        return false;
                    }
                }
                console.log('id '  + idx + ': ' + id);
                console.log('start, end time empty: ' + (!startTime && !endTime));
                console.log('exist: ' + (id && isInt(id) && parseInt(id) > 0 && !startTime && !endTime));
                // the empty row is the existed row
                if (id && isInt(id) && parseInt(id) > 0 && !startTime && !endTime) {
                    if (trackRecordsRemoved.indexOf(id) === -1) {
                        trackRecordsRemoved.push(parseInt(id));
                    }
                } else if (id && isInt(id) && parseInt(id) > 0 && startTime && endTime) {
                    var pos = trackRecordsRemoved.indexOf(parseInt(id));
                    if (pos !== -1) {
                        trackRecordsRemoved.splice(pos, 1);
                    }
                }

                if (startTime && endTime) {
                    var params = {
                        'report_date': reportDate,
                        'mst_work_statuses_id': Number(mstWorkStatusesId),
                        'mst_work_styles_id': Number(mstWorkStylesId),
                        'mst_projects_id': Number(getSelectVal(row, 'mst_projects_id', config.postfix)),
                        'start_time': reportDate + ' ' + startTime,
                        'end_time': reportDate + ' ' + endTime,
                        'break_time': toNumHours(getInputVal(row, 'break_time', config.postfix)),
                        'small_leave': toNumHours(getInputVal(row, 'small_leave', config.postfix)),
                        'leave_recovery': toNumHours(getInputVal(row, 'leave_recovery', config.postfix)),
                        'overtime': toNumHours(getInputVal(row, 'overtime', config.postfix)),
                        'midnight': toNumHours(getInputVal(row, 'midnight', config.postfix)),
                        'total_time': Number(getInputVal(row, 'total_time', config.postfix)),
                        'npc_regular_time': toNumHours(getInputVal(row, 'npc_regular_time', config.postfix)),
                        'npc_overtime': toNumHours(getInputVal(row, 'npc_overtime', config.postfix)),
                        'npc_midnight': toNumHours(getInputVal(row, 'npc_midnight', config.postfix)),
                        'remarks': getTextAreaVal(row, 'remarks', config.postfix)
                    };

                    if (id && isInt(id) && parseInt(id) > 0 && flag == types.update) {
                        params.id = Number(id);
                        reportData.update.push(params);
                        trackRowsChecked.update[reportData.insert.length - 1] = checkedRow[i];
                    } else if (flag == types.insert) {
                        reportData.insert.push(params);
                        trackRowsChecked.insert[reportData.insert.length - 1] = checkedRow[i];
                    }
                }
            });
        }
        console.log(trackRowsChecked);
        console.log(trackRecordsRemoved);
        console.log(reportData);

        return false;

        // var reportData = {
        //     'year': timeReportYear,
        //     'month': timeReportMonth,
        //     'userBeingEdit': userBeingEdit,
        // };

        $.ajax({
            url: submitUrl,
            data: reportData,
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status) {
                    $('.btnAction').append('<span class="success_action" style="display: inline-block; vertical-align: bottom; color: green; font-weight: bold;"><i>Your changes have been saved.</i></span>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON) {
                    var errors = jqXHR.responseJSON.errors;
                    var tagsSelect = ['mst_projects_id'];
                    var msgErrors = [];
                    Object.keys(errors).forEach(function (key) {
                        var split = key.toString().split('.');
                        var type = split[0];
                        var indexRecord = split.length > 1 ? split[1] : null;
                        var nameInput = split.length > 2 ? split[2] : null;
                        var tag = tagsSelect.indexOf(nameInput) !== -1 ? 'select' : 'input';
                        // highlight the error cells
                        if (indexRecord !== null && nameInput !== null) {
                            $(config.table || 'table')
                                .find('tr[data-index="'+trackRowsChecked[type][indexRecord]+'"] '+tag+'[name="'+nameInput+'[]"]')
                                .closest('td')
                                .addClass('error-border');
                        }
                        // store the other errors
                        if (errors.hasOwnProperty(type)){
                            if (msgErrors.indexOf(errors[type][0]) === -1) {
                                msgErrors.push(errors[type][0]);
                            }
                        }
                        if (indexRecord !== null && errors.hasOwnProperty(type+'.'+indexRecord)) {
                            if (msgErrors.indexOf(errors[type+'.'+indexRecord][0]) === -1) {
                                msgErrors.push(errors[type+'.'+indexRecord][0]);
                            }
                        }
                    });

                    // show the other error messages if exists
                    if (msgErrors.length > 0) {
                        $('#result-message').html('<div class="alert alert-danger"><ul><li>' + msgErrors.join('</li><li>') + '</li></ul></div>').show();
                    }
                }
            }
        });
    }

    function calculateRelation(rows) {
        var rangeRegularTime = toRangeNumHours(['08:30', '17:30']); // [8.5, 17.5] - 1 (lunch)
        var rangeOverTime    = toRangeNumHours(['17:30', '22:30']); // [17.5, 22.50]
        var rangeMidNight    = toRangeNumHours(['22:30', '06:30']); // [22.5, 29.5]22.5 + 1.5 + 6.5 -1 (lunch)
        var minStartTime     = toNumHours('08:30');
        var maxStartTime     = toNumHours('24:00');
        var minEndTime       = toNumHours('08:30');
        var maxEndTime       = toNumHours('24:00');
        var lunchTime        = toNumHours('11:30');

        var totalWorkTime = 0;
        var endTimeTrack = 0;
        var hasLunch = false;
        var cellsFirst = null;
        var flag = false;

        $.each(rows, function (idx, row) {
            var cells          = getCells($(row));
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

            // track first row
            if (idx === 0) {
                cellsFirst = cells;
            }

            // ignore the empty row
            if (startTime == 0 && endTime == 0) {
                resetValues($(row));
                //flag = true;
                console.log(1);
                return; // equal to 'continue;'
            }

            // show error if the start time does not sastify with the default values
            if (startTime < minStartTime || startTime > maxStartTime) {
                toggleErrorCell(cells, 'start_time');
                flag = true;
                console.log(2);
                return false;
            }

            // show error if the end time does not sastify with the default values
            if (endTime < minEndTime || endTime > maxEndTime) {
                toggleErrorCell(cells, 'end_time');
                flag = true;
                console.log(3);
                return false;
            }

            // show error if the start time is greater than the end time
            if (startTime > endTime) {
                toggleErrorCell(cells, 'start_time');
                flag = true;
                console.log(4);
                return false;
            }

            // show error if the start time of the next row is lower than the end time of the previous row
            if (endTimeTrack > 0 && startTime < endTimeTrack) {
                toggleErrorCell(cells, 'start_time');
                flag = true;
                console.log(5);
                return false;
            }

            // remove the highlights of the error cells if any
            toggleErrorCell(cells, ['start_time', 'end_time'], true);

            if (endTime <= rangeRegularTime[1]) { // in regular time
                breakTime  = hasLunch || endTime < lunchTime ? 0 : 1;
                totalTime  = endTime - startTime - breakTime;
                totalTime  = totalTime - npcRegularTime;

                // check the npc regular time
                if (totalTime < 0) {
                    toggleErrorCell(cells, 'npc_regular_time');
                    return false;
                }
                toggleErrorCell(cells, 'npc_regular_time', true);

                // store the real worked time
                totalWorkTime += totalTime + npcRegularTime;

                // show out the timesheet
                cells.break_time.element.val(normalize(breakTime));
                cellsFirst.small_leave.element.val(toHHMM(totalWorkTime >= workTime ? 0 : workTime - totalWorkTime, config.textDefault));
                cells.leave_recovery.element.val(config.textDefault);
                cells.overtime.element.val(config.textDefault);
                cells.midnight.element.val(config.textDefault);
                cells.total_time.element.val(normalize(totalTime));
                cells.npc_regular_time.element.val(toHHMM(npcRegularTime, config.textDefault));
                cells.npc_overtime.element.val(config.textDefault);
                cells.npc_midnight.element.val(config.textDefault);
                console.log('Regular Time');
            } else if (endTime <= rangeOverTime[1]) { // in overtime
                breakTime = hasLunch ? 0 : 1;
                totalTime = endTime - startTime - breakTime;

                // check the npc regular time
                totalTime = totalTime - npcRegularTime;
                if (totalTime < 0) {
                    toggleErrorCell(cells, 'npc_regular_time');
                    return false;
                }
                toggleErrorCell(cells, 'npc_regular_time', true);

                // check the leave recovery
                totalTime = totalTime - leaveRecovery;
                if (totalTime < 0) {
                    toggleErrorCell(cells, 'leave_recovery');
                    return false;
                }
                toggleErrorCell(cells, 'leave_recovery', true);

                // check the overtime
                if (totalTime + totalWorkTime >= workTime) {
                    overtime = totalTime + totalWorkTime - workTime;
                    totalTime = workTime - totalWorkTime;
                }

                // check the npc overtime
                if (npcOverTime > 0 && npcOverTime <= overtime) {
                    overtime = overtime - npcOverTime;
                } else if (npcOverTime > overtime) {
                    toggleErrorCell(cells, 'npc_overtime');
                    return false;
                }
                toggleErrorCell(cells, 'npc_overtime', true);

                // check npc regular time if any
                if (npcRegularTime > 0 && totalTime + totalWorkTime > workTime) {
                    toggleErrorCell(cells, 'npc_regular_time');
                    return false;
                }
                toggleErrorCell(cells, 'npc_regular_time', true);

                // check the leave recovery if any
                if (leaveRecovery > 0 && totalTime + totalWorkTime > workTime) {
                    toggleErrorCell(cells, 'leave_recovery');
                    return false;
                }
                toggleErrorCell(cells, 'leave_recovery', true);

                // store the real worked time
                totalWorkTime += totalTime + npcRegularTime;

                // show out the timesheet
                cells.break_time.element.val(normalize(breakTime));
                cellsFirst.small_leave.element.val(toHHMM(totalWorkTime >= workTime ? 0 : workTime - totalWorkTime, config.textDefault));
                cells.leave_recovery.element.val(toHHMM(leaveRecovery, config.textDefault));
                cells.overtime.element.val(normalize(overtime));
                cells.midnight.element.val(config.textDefault);
                cells.total_time.element.val(normalize(totalTime));
                cells.npc_regular_time.element.val(toHHMM(npcRegularTime, config.textDefault));
                cells.npc_overtime.element.val(toHHMM(npcOverTime, config.textDefault));
                cells.npc_midnight.element.val(config.textDefault);
                console.log('OverTime');
            } else if (endTime <= rangeMidNight[1]) { //in midnight
                breakTime = hasLunch ? 0 : 1;
                totalTime = endTime - startTime - breakTime;

                // check the npc regular time
                totalTime = totalTime - npcRegularTime;
                if (totalTime < 0) {
                    toggleErrorCell(cells, 'npc_regular_time');
                    return false;
                }
                toggleErrorCell(cells, 'npc_regular_time', true);

                // check the leave recovery
                totalTime = totalTime - leaveRecovery;
                if (totalTime < 0) {
                    toggleErrorCell(cells, 'leave_recovery');
                    return false;
                }
                toggleErrorCell(cells, 'leave_recovery', true);

                // check the overtime
                if (totalTime + totalWorkTime >= workTime) {
                    overtime = totalTime + totalWorkTime - workTime;
                    totalTime = workTime - totalWorkTime;
                }

                if (npcOverTime > 0 && npcOverTime <= overtime) {
                    overtime = overtime - npcOverTime;
                } else if (npcOverTime > overtime) {
                    toggleErrorCell(cells, 'npc_overtime');
                    return false;
                }
                toggleErrorCell(cells, 'npc_overtime', true);

                // check the npc midnight
                midnight = endTime - rangeMidNight[0];
                if (npcMidNight > 0 && npcMidNight <= midnight) {
                    midnight = midnight - npcMidNight;
                } else if (npcMidNight > midnight) {
                    toggleErrorCell(cells, 'npc_midnight');
                    return false;
                }
                toggleErrorCell(cells, 'npc_midnight', true);

                overtime = overtime - midnight - npcMidNight;

                // check the npc regular time if any
                if (npcRegularTime > 0 && totalTime + totalWorkTime > workTime) {
                    toggleErrorCell(cells, 'npc_regular_time');
                    return false;
                }
                toggleErrorCell(cells, 'npc_regular_time', true);

                // check the npc leave recovery if any
                if (leaveRecovery > 0 && totalTime + totalWorkTime > workTime) {
                    toggleErrorCell(cells, 'leave_recovery');
                    return false;
                }
                toggleErrorCell(cells, 'leave_recovery', true);

                // store the real worked time
                totalWorkTime += totalTime + npcRegularTime;

                // show out the timesheet
                cells.break_time.element.val(normalize(breakTime));
                cellsFirst.small_leave.element.val(toHHMM(totalWorkTime >= workTime ? 0 : workTime - totalWorkTime, config.textDefault));
                cells.leave_recovery.element.val(toHHMM(leaveRecovery, config.textDefault));
                cells.overtime.element.val(normalize(overtime));
                cells.midnight.element.val(normalize(midnight));
                cells.total_time.element.val(normalize(totalTime));
                cells.npc_regular_time.element.val(toHHMM(npcRegularTime, config.textDefault));
                cells.npc_overtime.element.val(toHHMM(npcOverTime, config.textDefault));
                cells.npc_midnight.element.val(toHHMM(npcMidNight, config.textDefault));
                console.log('MidNight');
            }

            // check the lunch time
            if (!hasLunch && endTime >= toNumHours(lunchTime)) {
                hasLunch = true;
            }

            // track the previous end time
            endTimeTrack = endTime;
            updateFlag(row, 'update');
        });
        return !flag;
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
            cells.break_time.element.val(toHHMM(breakTime, config.textDefault));
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
            cells.break_time.element.val(toHHMM(breakTime, config.textDefault));
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

            cells.break_time.element.val(toHHMM(breakTime, config.textDefault));
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
        return !flag;
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

    function isInt(value) {
        return !isNaN(value) && parseInt(value) == value;
    }

    function toHHMM(numHours) {
        return !isNaN(numHours) && parseFloat(numHours) == numHours && Number(numHours) !== 0
            ? pad2LeftZero(Number(numHours) - Number(numHours)%1) + ':' + pad2LeftZero((Number(numHours)%1)*60)
            : '';
    }
</script>
@endpush
