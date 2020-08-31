(function() {
    $('#habit').hide();
    $('.resetHabit').hide();

    var habitsOptions = {
        lastSel: 0,
        defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
        status_slt: [ "Current:Current", "Developed:Developed", "All:All"],
        freq_slt: [ "Daily:Daily", "Weekly:Weekly", "Monthly:Monthly"]
    };

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

    $(function (){
        $("#habits").jqGrid({
            url: "/habits/list",
            datatype: "json",
            guiStyle: "bootstrap",
            mtype: "GET",
            colNames: ["", "Added", "Habit", "Start", "Frequency", "Status"],
            colModel: [
             { name: 'imgCol', sortable: false, align: "center", width: 20, formatter: function () {return "<span class='glyphicon glyphicon-th-list' style='cursor: pointer;'></span>";}, classes: 'clickableTitle', search: false},
            { name: "created_at", align: "center", width: 80, formatter:'date', formatoptions: { newformat:'Y-m-d'}, search: false},
            { name: "name", width: 350, editable:true, search: false },
            { name: "start", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false,
            width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:habitsOptions.defaultDate, dataInit: function (element) {
                               $(element).datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    todayBtn: 'linked',
                                    orientation: "bottom"
                                });
                            }},
            },
            { name: "freq", width: 100, align: "center", editable:true, edittype:"select", editoptions:{value: habitsOptions.freq_slt.join(";")}, formatter:'select', search: false},
            { name: "status", width: 150, align: "center", editable:true, edittype:"select", editoptions:{value: habitsOptions.status_slt.join(";")}, formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: habitsOptions.status_slt.join(";") }}
            ],
            pager: "#habits_pager",
            rowNum: 100,
            height: "100%",
            rowList: [],
            pgbuttons: false,
            pgtext: null,
            sortname: "created_at",
            sortorder: "asc",
            viewrecords: true,
            gridview: true,
            hidegrid: false,
            autowidth: true,
            shrinkToFit: true,
            autoencode: false,
            rownumbers: true,
            editurl: '/habits/edit',
            ondblClickRow: function (id) {
                $(this).jqGrid('editRow', id, true, null, null, '', '', function() {
                    $(this).trigger("reloadGrid");
                });
            },
            onSelectRow: function (id) {
                if (id && id !== habitsOptions.lastSel) {
                    if (typeof habitsOptions.lastSel !== "undefined") {
                        $(this).jqGrid('restoreRow', habitsOptions.lastSel);
                    }
                    habitsOptions.lastSel = id;
                }
            },
            loadComplete: function() {
                $('#habit').hide();
                $('.resetHabit').hide();
                $('#habitName').text('');
                $('#habitInfo').html('');
                $('#habitsInterval').html('');
            },
            onCellSelect: function (rowid, iCol, cellcontent, e) {
                var $dest = $(e.target), $td = $dest.closest('td');
                var today = $.datepicker.formatDate('yy-mm-dd', new Date());
                var freq = 'Day';

                if ($td.hasClass("clickableTitle")) {
                    $('#habit').show();
                    $('.resetHabit').show();
                    $('#habitsInterval').show();

                     $('#reset').on('click', function(){
                        resetHabit(rowid).done(function(r){
                            $('#habit').show();
                            $('.resetHabit').show();
                            $('#habitsInterval').hide();
                        });
                     });

                    getHabitInfo(rowid).done(function(r){
                        var habit = r[0];
                        var start = habit.start;
                        var freq = '';
                        $('#habitName').text('');
                        $('#habitName').append(habit.name);
                        $('#habitInfo').html('');
                        $('#habitInfo').append(
                            '<li><b>Start Date:</b> ' + habit.start + '</li>' + "\n" +
                            '<li><b>Frequency:</b> ' + habit.freq + '</li>'
                        );

                        switch (habit.freq) {
                            case 'Daily':
                            freq = 'Day';
                            break;
                            case 'Weekly':
                            freq = 'Week';
                            break;
                            case 'Monthly':
                            freq = 'Month';
                            break;
                        }

                        getHabitDays(rowid).done(function(r){
                            $('#habitsInterval').html('');
                            var days = r;
                            if(days.length > 0) {
                                loadHabitTable(days, freq, today);
                                $('#habitsInterval').on('change', 'input[name="chk"]', function() {
                                    var d = new Date();
                                    $(this).val(this.checked ? 1 : 0);
                                    var chkVal = $(this).val();
                                    var hours = (d.getHours() < 10? '0' : '') + d.getHours();
                                    var min = (d.getMinutes() < 10? '0' : '') + d.getMinutes();
                                    var currentTime = hours + ':' + min;
                                    var timeSet = (chkVal == 1) ? currentTime : '';
                                    var data = {
                                        dayId: $(this).attr('id'),
                                        timeSet: timeSet,
                                        chkVal: $(this).val()
                                    };
                                    saveHabit(data).done(function(r){
                                        r = $.parseJSON(r);
                                        var timeUpdate = (r.chkVal == 1) ? ' <span class="fa fa-clock-o savedtime"></span> ' + r.timeSet : '';
                                        //console.log(r);
                                        $('#saveResult').text(r.status);
                                        $('#saveResult').show().fadeOut(500);
                                        $('#tid_'+r.dayId).html(timeUpdate);

                                    });
                                });
                            } else {
                                populateHabit(rowid, start).done(function(r){
                                    $('#habitsInterval').html('');
                                    var days = r;
                                    if(days.length > 0) {
                                        loadHabitTable(days, freq, today);
                                    }
                                });
                            }
                        });

                    }); // getHabitInfo
                }
            }
        }); // onCellSelect

        var editOptions = {
            keys: true,
            successfunc: function () {
                var $self = $(this);
                setTimeout(function () {
                    $self.trigger("reloadGrid");
                }, 50);
            }
        };

        $("#habits").jqGrid('navGrid', '#habits_pager', {add: false, edit: false, del: true, search: false, refresh: false});
        $("#habits").jqGrid('inlineNav', '#habits_pager', {addParams: {position: "last",addRowParams: editOptions},editParams: editOptions});
        jQuery("#habits").jqGrid('filterToolbar');
    });

    function getHabitInfo(rowid) {
        return $.get('/habit/gethabitinfo', {hid: rowid}, 'json');
    }

    function getHabitDays(rowid) {
        return $.get('/habit/gethabitdays', {hid: rowid}, 'json');
    }

    function populateHabit(rowid, start) {
        return $.get('/habit/populatehabit', {hid: rowid, start: start}, 'json');
    }

    function loadHabitTable(days, freq, today) {
        for(var i = 0, count = days.length; i < count ; i++) {
            var hl = (days[i].date == today) ? ' class="highlight"' : '';
            var isChecked = (days[i].check == 1) ? 'checked="checked"' : '';
            var isDisabled = (days[i].date != today) ? ' disabled="disabled"' : '';
            var timeSet = (days[i].check == 1) ? ' <span class="fa fa-clock-o savedtime"></span> ' + days[i].time : '';
            $('#habitsInterval').append(
                '<tr ' + hl +'>' + "\n" +
                '<td width="34%">' + days[i].date + '</td>' + "\n" +
                '<td width="33%">' + freq + ' ' + days[i].day + '</td>' + "\n" +
                '<td width="33%">' + '<input id="' + days[i].id  + '" name="chk" type="checkbox" value="' + days[i].check  + '"' + isChecked + isDisabled + '><span id="tid_' + days[i].id + '">' + timeSet + '</span></td>' + "\n" +
                '</tr>' + "\n"
            );
        }
    }
    function resetHabit(rowid) {
        return $.post('/habit/resethabit', {hid: rowid}, 'json');
    }

    function saveHabit(data) {
        return $.post('/habit/savehabit', data);
    }

})();
