export default class DataTable {

    constructor() {
        this.init();
        this.hoverRow();
        this.deleteRow();
        this.export();
        this.initFilters();
        this.resetFilters();
        this.columnsVisibilityFilter();
        this.tableViewFilter();
    }

    config() {
        return {
            scrollY: '500px',
            scrollCollapse: true,
            mark: {
                filter: function(node){
                    var datatable = $(node.parentElement).closest('.dataTables_wrapper')
                    var datatableFilter = $('.datatable__filters th', datatable)
                        .eq($(node).closest("td").index())
                        .find('.datatable__filter');

                    if(
                        datatableFilter.hasClass('datatable__filter--select') ||
                        datatableFilter.hasClass('datatable__filter--select-multi') ||
                        datatableFilter.hasClass('datatable__filter--select-multi-ajax')
                    ){
                        return false;
                    }
                    return true;
                }
            },
            scrollX: true,
            language: {
                url: '/js/admin-panel/vendor/dataTables/lang/' + $("html").attr("lang") + '.json'
            },
            drawCallback: function( settings ) {
                $('.dt-button','.dataTables_wrapper').removeClass("dt-button");
            },
            ajax: {
                error: function (jqxhr, textStatus, thrownError) {
                    if(thrownError == 'Unauthorized' || jqxhr.status == 401 || jqxhr.status == 419) {
                        window.location.replace(routeLogin);
                    }
                }
            },
        }
    }

    init() {
        let dtObject = this;
        $('.ajaxDataTable').each(function () {
            dtObject.draw($(this));
        });

        $('.clientDataTable').each(function () {
            $(this).dataTable($.extend(true, {}, this.config(), {

            }));
        });

        $(document).on( 'init.dt', function ( e, settings ) {
            var api = new $.fn.dataTable.Api( settings );

            if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
                $('.clientDataTable, .ajaxDataTable').siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">'+ _t('Delete selected') +'</a>');
            }

            $(".dataTables_filter input").unbind();
            $(".dataTables_filter input").on('input', function(e, autoSelected) {
                if(autoSelected) {
                    api.search("");
                    return;
                }
                // If the length is 3 or more characters, or the user pressed ENTER, search
                if(this.value.length >= 3) {
                    // Call the API search function
                    api.search(this.value).draw();
                }
                // Ensure we clear the search if they backspace far enough
                if(this.value == "") {
                    api.search("").draw();
                }
                return;
            });
            $(".dataTables_filter input").on('keyup', function(e, autoSelected) {
                if(autoSelected) {
                    api.search("");
                    return;
                }
                // If the length is 3 or more characters, or the user pressed ENTER, search
                if(e.keyCode == 13) {
                    // Call the API search function
                    api.search(this.value).draw();
                }
                return;
            });
        });
    }

    hoverRow() {
        $(document).on( 'click', '.DTFC_LeftWrapper .dataTable tbody tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $(this).closest('.dataTables_wrapper').find(".dataTables_scrollBody .dataTable tbody tr").eq($(this).index())
                    .removeClass('selected');
            } else {
                $(this).removeClass('selected');
                $(this).addClass('selected');
                $(this).closest('.dataTables_wrapper').find(".dataTables_scrollBody .dataTable tbody tr").eq($(this).index())
                    .addClass('selected');
            }
        });

        $(document).on( 'click', '.dataTables_scrollBody .dataTable tbody tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $(this).closest('.dataTables_wrapper').find(".DTFC_LeftWrapper .dataTable tbody tr").eq($(this).index())
                    .removeClass('selected');
            }else {
                $(this).removeClass('selected');
                $(this).addClass('selected');
                $(this).closest('.dataTables_wrapper').find(".DTFC_LeftWrapper .dataTable tbody tr").eq($(this).index())
                    .addClass('selected');
            }
        });

        $(document).on('mouseover mouseout', '.DTFC_LeftWrapper .dataTable tbody tr', function () {
            if ($(this).hasClass('hovered')) {
                $(this).removeClass('hovered');
                $(this).closest('.dataTables_wrapper').find(".dataTables_scrollBody .dataTable tbody tr").eq($(this).index())
                    .removeClass('hovered');
            } else {
                $(this).removeClass('hovered');
                $(this).addClass('hovered');
                $(this).closest('.dataTables_wrapper').find(".dataTables_scrollBody .dataTable tbody tr").eq($(this).index())
                    .addClass('hovered');
            }
        });

        $(document).on('mouseover mouseout', '.dataTables_scrollBody .dataTable tbody tr', function () {
            if ($(this).hasClass('hovered')) {
                $(this).removeClass('hovered');
                $(this).closest('.dataTables_wrapper').find(".DTFC_LeftWrapper .dataTable tbody tr").eq($(this).index())
                    .removeClass('hovered');
            }else {
                $(this).removeClass('hovered');
                $(this).addClass('hovered');
                $(this).closest('.dataTables_wrapper').find(".DTFC_LeftWrapper .dataTable tbody tr").eq($(this).index())
                    .addClass('hovered');
            }
        });
    }

    deleteRow() {
        $(document).on('click', '.data-table-delete-single', function(evt) {
            evt.preventDefault();
            var form = $(this).parent('form');

            swal({
                text: _t('Are you sure you want to delete the selected item?'),
                type: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                cancelButtonText: _t('Cancel'),
                cancelButtonClass: "btn btn-default",
                confirmButtonText: _t('Delete'),
                confirmButtonClass: "btn btn-danger",
            }).then(function(result) {
                if(result.value) {
                    form.submit();
                }
            });
        });
    }

    export() {
        $('.btn-export-dt').click(function(evt) {
            evt.preventDefault();
            let targetTable = $(this).data('target-table');
            let recordsDisplay = $('#' + targetTable).dataTable().api().page.info().recordsDisplay;

            if(recordsDisplay > 10000) {
                swal({
                    text: _t("The maximum allowed number of rows that can be exported is :numRows", {
                        numRows: 10000,
                    }),
                    type: "warning",
                    showCancelButton: false,
                });

                return;
            }

            swal({
                text: _t('Are you sure you want to export the selected items?'),
                type: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                cancelButtonText: _t('Cancel'),
                cancelButtonClass: "btn btn-default",
                confirmButtonText: _t('Yes'),
                confirmButtonClass: "btn btn-success",
            }).then(function(result) {
                if(result.value) {
                    let params = $('#' + targetTable).dataTable().api().ajax.params();
                    let url = $('#' + targetTable).dataTable().api().ajax.url();
                    let visible = $('#' + targetTable).dataTable().api().columns().visible().toArray();
                    for (let column in params.columns) {
                        params.columns[column].visible = visible[column];
                    }

                    params.export = true;
                    params.length = -1;

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: params,
                        headers: {
                            'X-CSRF-TOKEN': window._token
                        },
                        success() {
                            swal({
                                html: _t("We've started exporting the selected items. You will receive an email notification when the export is complete.") + '<br/><a href="/reports">' + _t('Go to Reports section') + '</a>',
                                type: "success",
                                showCancelButton: false,
                            })
                        }
                    });
                }
            });
        }) ;
    }

    initFilters(container){
        var prefix = container ? container + ' ' : '';

        $(prefix + '.datatable__filter--select-multi').each(function () {
            let current = $(this);
            current.select2({
                language: $("html").attr("lang"),
                allowClear: true,
                cache: true,
                debug: true,
                placeholder: current.data('placeholder'),
            });
        });

        $(document).on('change', prefix + '.datatable__filter--select-multi', function (evt, autoSelected) {
            if(autoSelected) {
                return;
            }

            let current = $(this);
            let values = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( values.join('|'), true, false )
                .draw();
        });


        $(prefix + '.datatable__filter--select-multi-ajax').each(function () {
            let current = $(this);
            current.select2({
                language: $("html").attr("lang"),
                dropdownCssClass: "select2-" + current.attr("name"),
                ajax: {
                    url: function (params) {
                        return current.attr('data-url');
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            needle: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        var selectobj = $.map(data, function (v) {
                            return {
                                'text': v[current.data('text_field')],
                                'id': v[current.data('id_field')] ? v[current.data('id_field')] : v['id'],
                            }
                        });
                        return { results: selectobj };
                    },
                    cache: true,
                    error: function (err) {

                    }
                },
                placeholder: current.data('placeholder'),
                minimumInputLength: 2,
                allowClear: true
            });
        });

        $(document).on('change', prefix + '.datatable__filter--select-multi-ajax', function (evt, autoSelected) {
            if(autoSelected) {
                return;
            }

            let current = $(this);
            let values = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( values.join('|'), true, false )
                .draw();
        });

        $(prefix + '.datatable__filter--select').each(function () {
            let current = $(this);

            current.select2({
                language: $("html").attr("lang"),
                allowClear: true,
                cache: true,
                debug: true,
                placeholder: current.data('placeholder'),
            });
        });

        $(document).on('change', prefix + '.datatable__filter--select', function (evt, autoSelected) {

            if(autoSelected) {
                return;
            }

            let current = $(this);
            let value = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( value )
                .draw();
        });

        $(prefix + '.datatable__filter--date-range-picker').each(function () {
            let current = $(this);
            let locale = $.extend(true, {}, daterangepickerLocale, {
                format: 'DD/MM/YYYY'
            });

            let options = {
                timePicker: false,
                showDropdowns: true,
                autoUpdateInput: false,
                showWeekNumbers: true,
                linkedCalendars: false,
                alwaysShowCalendars: true,
                locale: locale
            };

            current.daterangepicker(options);

            current.on('apply.daterangepicker', function (ev, picker) {
                $(this)
                    .val(picker.startDate.format(locale.format) + ' - ' + picker.endDate.format(locale.format))
                    .trigger('change');
            });

            current.on('cancel.daterangepicker', function (ev, picker) {
                $(this)
                    .val('')
                    .trigger('change');
            });
        });

        $(document).on('change', prefix + '.datatable__filter--date-range-picker', function (evt, autoSelected) {

            if(autoSelected) {
                return;
            }

            let current = $(this);
            let value = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( value )
                .draw();
        });

        $(prefix + '.datatable__filter--datetime-range-picker').each(function () {
            let current = $(this);

            let options = {
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                showDropdowns: true,
                autoUpdateInput: false,
                showWeekNumbers: true,
                linkedCalendars: false,
                alwaysShowCalendars: true,
                locale: daterangepickerLocale
            };

            current.daterangepicker(options);

            current.on('apply.daterangepicker', function (ev, picker) {
                $(this)
                    .val(picker.startDate.format(daterangepickerLocale.format) + ' - ' + picker.endDate.format(daterangepickerLocale.format))
                    .trigger('change');
            });

            current.on('cancel.daterangepicker', function (ev, picker) {
                $(this)
                    .val('')
                    .trigger('change');
            });
        });

        $(document).on('change', prefix + '.datatable__filter--datetime-range-picker', function (evt, autoSelected) {

            if(autoSelected) {
                return;
            }

            let current = $(this);
            let value = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( value )
                .draw();
        });

        $(document).on('input', prefix + '.datatable__filter--search', function (evt, autoSelected) {
            if(autoSelected) {
                return;
            }

            let current = $(this);
            let value = $(current).val();
            let tableId = $(current).data('table_target');
            let targetTable = $('#' + tableId);
            let columnTarget = $(current).data('column_target');

            targetTable.dataTable()
                .api()
                .columns( columnTarget )
                .search( value )
                .draw();
        });
    }

    resetFilters() {
        let dtObject = this;

        $('.btn-reset-filters-dt').on('click', function (evt) {
            evt.preventDefault();
            let tableID = $(this).data('target-table');
            let table = $('#' + tableID);
            let tableParams = JSON.parse(table.attr('data-params'));
            let viewsSelect = $('select[name="view"][data-target-table="' + tableID + '"]');

            if(viewsSelect.length && viewsSelect.val() != 'default') {
                let selectedView = viewsSelect.find('option:selected');
                localStorage.setItem(tableID, selectedView.attr('data-view-params'));
            }else{
                localStorage.removeItem(tableID);
            }

            dtObject.resetFiltersInputs(tableID);
            dtObject.resetColumnsVisibility(tableID);

            if ($.fn.DataTable.isDataTable(table)) {
                table.dataTable().fnDestroy();
            }

            dtObject.draw(table);
        });
    }

    resetFiltersInputs(tableID) {
        $('input.datatable__filter[data-table_target="' + tableID + '"]').each(function () {
            $(this).val('');
            $(this).trigger('input', true);
        });
        $('select.datatable__filter[data-table_target="' + tableID + '"]').each(function () {
            $(this).val('');
            $(this).trigger('change', true);
        });
        $('#' + tableID + '_filter input').each(function () {
            $(this).val('');
            $(this).trigger('input', true);
        });
    }

    resetColumnsVisibility(tableID) {
        let table = $('#' + tableID);
        let tableParams = JSON.parse(table.attr('data-params'));

        $(table).dataTable()
            .api()
            .columns()
            .visible(true, true);

        let checkboxes = $('.dt_col_visibility_filter[data-table_target="' + tableID + '"]');
        checkboxes.each(function () {
            let checkbox = $(this);
            $(tableParams.columns).each(function () {
                let column = this;
                if (checkbox.attr('id') == column.className) {
                    if(column.visible == undefined || column.visible) {
                        checkbox
                            .prop('checked', true)
                            .iCheck('update');
                    } else {
                        checkbox
                            .prop('checked', false)
                            .iCheck('update');
                    }
                }
            })
        })
    }

    toggleActions(tableId, disable) {
        $('.dt_save-view_btn[data-target-table="' + tableId + '"]').prop('disabled', disable);
        $('.dt_delete-view_btn[data-target-table="' + tableId + '"]').prop('disabled', disable);
        $('.select2-create_tag[data-target-table="' + tableId + '"]').prop('disabled', disable);
        $('button[data-target="#' + tableId + 'ColumnsVisibilityModal"]').prop('disabled', disable);
        $('button[data-target-table="' + tableId + '"]').prop('disabled', disable);
    }

    hideViewActions(tableId) {
        $('.dt_save-view_btn[data-target-table="' + tableId + '"]').hide();
        $('.dt_delete-view_btn[data-target-table="' + tableId + '"]').hide();
    }

    showViewActions(tableId) {
        $('.dt_save-view_btn[data-target-table="' + tableId + '"]').show();
        $('.dt_delete-view_btn[data-target-table="' + tableId + '"]').show();
    }

    toggleViewInfoMessage(tableId, display) {
        $('.datatable__view-info-message[data-target-table="' + tableId + '"]').css('display', display);
    }

    draw($table, calledFromTableView) {
        let tableId = $table.attr('id');
        let initParams = JSON.parse($table.attr('data-params'));
        let dtObject = this;

        //Transform order column names to column index. Can't be done in initParamsTransformed because order doesn't work on Reset Filters
        for (let i = 0; i < initParams.order.length; i++) {
            for (let j = 0; j < initParams.columns.length; j++) {
                if (initParams.order[i][0] == initParams.columns[j].data) {
                    initParams.order[i][0] = j.toString();
                }
            }
        }

        let ignoreLocalStorage = true;
        let initSearchCols = [];
        let initVisibleCols = [];
        let initParamsTransformed = {
            order: _.map(initParams.order, function (i) {
                return [
                    i[0].toString(),
                    i[1]
                ]
            }),
            search: null,
            searchCols: [],
            visibleCols: [],
        };

        calledFromTableView = calledFromTableView || false;

        initParams.processing = true;
        initParams.serverSide = true;

        for (let ic in initParams.columns) {
            let column = initParams.columns[ic];
            if(column.hasOwnProperty('search')) {
                initSearchCols.push(column.search);
            }else{
                initSearchCols.push(null);
            }

            initVisibleCols.push({
                data: column.data,
                column_target: '.dt_col_' + column.data,
                visible: column.hasOwnProperty('visible') && !column.visible ? 'false' : 'true',
            })
        }
        initParams.searchCols = initSearchCols;
        initParamsTransformed.visibleCols = initVisibleCols;
        initParamsTransformed.searchCols = initSearchCols;

        if(calledFromTableView && localStorage.hasOwnProperty(tableId)) {
            ignoreLocalStorage = false;
        }else if(localStorage.hasOwnProperty(tableId) && ( !initParams.hasOwnProperty('ignoreLocalStorage') || !initParams.ignoreLocalStorage)) {
            ignoreLocalStorage = false;
        }

        if(!ignoreLocalStorage ) {
            let savedParams = JSON.parse(localStorage.getItem(tableId));
            let visibleCols = savedParams.hasOwnProperty('visibleCols') ? savedParams.visibleCols : null;

            initParams.searchCols = savedParams.searchCols;
            initParams.order = savedParams.order;
            initParams.search = { "search": savedParams.search };

            if(visibleCols) {
                for (let c in initParams.columns) {
                    let visible = visibleCols.hasOwnProperty(c) ? visibleCols[c].visible : true;
                    initParams.columns[c].visible = visible == 'false' || visible == false ? false : true;
                }
            }
        }

        let createdRowCallback = $table.data('created_row_callback');

        initParams = $.extend(true, {}, initParams, {
            createdRow: function (row, data, dataIndex) {
                if(createdRowCallback && window.hasOwnProperty(createdRowCallback)) {
                    window[createdRowCallback](row, data, dataIndex);
                }
            }
        });

        let params =  $.extend(true, {}, this.config(), initParams);

        let table = $table.DataTable(params);

        table.on('preDraw', function () {
            dtObject.toggleActions(tableId, true);
        });

        table.on('draw', function (evt) {
            let api = $(this).dataTable().api();
            let params = api.ajax.params();
            let visible = api.columns().visible().toArray();

            // To been assigned in localstorage obj.
            let searchCols = [];
            let orderCols = [];
            let visibleCols = [];
            let search = null;

            for(let c in params.columns) {
                let column = params.columns[c];
                let column_target = '.dt_col_' + column.data;
                //Setup search pattern for each column
                if(column.hasOwnProperty('search') && column.search.hasOwnProperty('value') && column.search.value) {

                    // Search filer
                    let searchFilter = $('input.datatable__filter--search[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');
                    // Select filter
                    let selectFilter = $('select.datatable__filter--select[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');
                    // Multi select filter
                    let multiSelectFilter = $('select.datatable__filter--select-multi[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');
                    // Multi select filter
                    let multiSelectAjaxFilter = $('select.datatable__filter--select-multi-ajax[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');
                    // Date Range Picker filter
                    let dateRangePickerFilter = $('input.datatable__filter--date-range-picker[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');
                    // DateTime Range Picker filter
                    let datetimeRangePickerFilter = $('input.datatable__filter--datetime-range-picker[data-column_target="' + column_target + '"][data-table_target="' + tableId  + '"]');

                    if(searchFilter.length) {
                        $(searchFilter).val(column.search.value);
                    }

                    if(selectFilter.length) {
                        $(selectFilter).val(column.search.value);
                        $(selectFilter).trigger('change', true);
                    }

                    if(multiSelectFilter.length) {
                        let valuesToArr = column.search.value.split('|');
                        $(multiSelectFilter).val(valuesToArr);
                        $(multiSelectFilter).trigger('change', true);
                    }
                    if(multiSelectAjaxFilter.length) {
                        let valuesToArr = column.search.value.split('|');
                        $.each(valuesToArr, function (i, value) {
                            if(!multiSelectAjaxFilter.find("option[value='" + value + "']").length) {
                                let newOption = new Option(value, value, true, true);
                                multiSelectAjaxFilter.append(newOption);
                            }
                        });
                        $(multiSelectAjaxFilter).val(valuesToArr);
                        $(multiSelectAjaxFilter).trigger('change', true);
                    }
                    if(dateRangePickerFilter.length) {
                        $(datetimeRangePickerFilter).val(column.search.value);
                    }
                    if(datetimeRangePickerFilter.length) {
                        $(datetimeRangePickerFilter).val(column.search.value);
                    }
                    // Assign search value for local storage object
                    searchCols[c] = {search: column.search.value};
                }else {
                    // Set search value to null for local storage object
                    searchCols[c] = null;
                }

                //Assign visibility of the column for local storage object
                visibleCols[c] = {
                    data: column.data,
                    column_target: column_target,
                    visible: visible[c] ? 'true' : 'false',
                };
            }

            if(params.hasOwnProperty('order')) {
                for(let o in params.order) {
                    let order = params.order[o];
                    if(order.hasOwnProperty('column') && order.hasOwnProperty('dir')) {
                        orderCols.push([order.column.toString(), order.dir]);
                    }
                }
            }

            if(params.hasOwnProperty('search')) {
                search = $.trim(params.search.value) == '' ? null : params.search.value;
            }

            let savedParams = localStorage.hasOwnProperty(tableId) ? JSON.parse(localStorage.getItem(tableId)) : {};
            let newParams = $.extend(true, {}, savedParams, {
                searchCols: searchCols,
                order: orderCols,
                search: search,
                visibleCols: visibleCols
            });
            newParams.order = orderCols;

            localStorage.setItem(tableId, JSON.stringify(newParams));

            dtObject.toggleActions(tableId, false);

            let viewsSelect = $('.select2-create_tag[data-target-table="' + tableId + '"]');
            let selectedView = $(viewsSelect.find('option:selected')[0]);

            if(selectedView.length && selectedView.val() == 'default') {
                dtObject.toggleViewInfoMessage(tableId, 'none');

                if(!_.isEqual(initParamsTransformed, newParams)) {
                    $('.' + tableId + 'FiltersAlert').css('display', 'block');
                }else{
                    $('.' + tableId + 'FiltersAlert').css('display', 'none');
                }
            }else if(!selectedView.length){
                $('.' + tableId + 'FiltersAlert').css('display', 'none');
            }else{
                let selectedViewParams = selectedView.attr('data-view-params') ? JSON.parse(selectedView.attr('data-view-params')) : [];

                let paramsIsEqual = _.isEqual(
                    _.omit(newParams, ['last_used_view']),
                    _.omit(selectedViewParams, ['last_used_view']),
                );

                if(!paramsIsEqual && !selectedView.data('default')) {
                    dtObject.toggleViewInfoMessage(tableId, 'block');
                }else{
                    dtObject.toggleViewInfoMessage(tableId, 'none');
                }

                if(!paramsIsEqual) {
                    $('.' + tableId + 'FiltersAlert').css('display', 'block');
                }else{
                    $('.' + tableId + 'FiltersAlert').css('display', 'none');
                }
            }

            if(!breakpoint("xs")) {
                setTimeout(function () {
                    dtObject.fixedColumns(tableId, 2);
                }, 0);
            }
        });
    }

    fixedColumns(tableId, fixedCount) {
        let tableData = $('#' + tableId);
        let tableHeader = $('#' + tableId).closest('.dataTables_scroll').find('.dataTables_scrollHead table');

        let leftWidth = 0;
        for (let i = 1; i <= fixedCount; i++) {
            tableHeader.find('th:nth-child(' + i + ')').each(function () {
                let cell = $(this);

                cell.css('position', 'sticky');
                cell.css('left', leftWidth);
                cell.css('background-color', '#ffffff !important');
                cell.css('z-index', 1);
            });

            tableData.find('td:nth-child(' + i + ')').each(function () {
                let cell = $(this);
                let row = cell.closest('tr')

                cell.css('position', 'sticky');
                cell.css('left', leftWidth);
                let backColor = row.css('background-color');
                if (backColor != "rgb(249, 249, 249)") {
                    backColor = '#ffffff'
                }
                cell.css('background-color', backColor);
                cell.css('z-index', 1);

                row.hover(function () {
                    cell.css('background-color', '#dff0d8');
                },function () {
                    cell.css('background-color', backColor);
                })

                row.click(function () {
                    if (cell.hasClass('selected')) {
                        cell.removeClass('selected');
                    } else {
                        cell.addClass('selected')
                    }
                });
            });

            leftWidth = leftWidth + 1 + tableHeader.find('th:nth-child(' + i + '):first').width();
        }
    }

    columnsVisibilityFilter() {
        let dtColVisibilityFilters = $('.dt_col_visibility_filter');

        $(dtColVisibilityFilters).on('ifCreated', function () {
            let tableId = $(this).data('table_target');
            let column_target = $(this).data('column_target');
            let initTableParams = $('#' + tableId).data('params');

            if(initTableParams.hasOwnProperty('ignoreLocalStorage') && initTableParams.ignoreLocalStorage == true) {
                for (let c in initTableParams.columns) {
                    let column = initTableParams.columns[c];

                    if(('.dt_col_' + column.data) != column_target) {
                        continue;
                    }

                    if(column.hasOwnProperty('visible') && column.visible == false) {
                        $(this).prop('checked', false).iCheck('update');
                    }else{
                        $(this).prop('checked', true).iCheck('update');
                    }

                    break;
                }

                return;
            }

            let savedParams = localStorage.hasOwnProperty(tableId) ? JSON.parse(localStorage.getItem(tableId)) : null;

            if(!savedParams || !savedParams.hasOwnProperty('visibleCols')) {
                return;
            }

            for (let c in savedParams.visibleCols) {
                let isVisible = savedParams.visibleCols[c].visible;

                if(savedParams.visibleCols[c].column_target != column_target) {
                    continue;
                }

                if(isVisible == 'false' || !isVisible) {
                    $(this).prop('checked', false).iCheck('update');
                }else{
                    $(this).prop('checked', true).iCheck('update');
                }
                break;
            }
        });

        $(dtColVisibilityFilters).iCheck({
            checkboxClass: 'icheckbox_square-green',
            increaseArea: '50%' // optional
        });

        $(dtColVisibilityFilters).on('ifUnchecked', function (evt) {
            let tableId = $(this).data('table_target');
            let table = $('#' + tableId);
            let columnTarget = $(this).data('column_target');

            table.dataTable().api()
                .columns( columnTarget )
                .visible( false )
                .search('');

            table.DataTable().columns.adjust().draw();
        });

        $(dtColVisibilityFilters).on('ifChecked', function (evt) {
            let tableId = $(this).data('table_target');
            let table = $('#' + tableId);
            let columnTarget = $(this).data('column_target');

            table.dataTable().api()
                .columns( columnTarget )
                .visible( true )
                .search('');

            table.DataTable().columns.adjust().draw();
        });
    }

    tableViewFilter() {
        let dtObject = this;
        let select2CreateTag = $('.select2-create_tag');
        let saveBtns = $('.dt_save-view_btn');
        let deleteBtns = $('.dt_delete-view_btn');

        select2CreateTag.each(function () {
            let current = $(this);
            let savedParams = localStorage.hasOwnProperty(current.data('target-table')) ? JSON.parse(localStorage.getItem(current.data('target-table'))) : {};
            let initTableOptions = $('#' + current.data('target-table')).data('params');

            current.select2({
                tags: true,
                allowClear: false,
                placeholder: current.data('placeholder'),
                createTag: function (params) {
                    if(current.val() == 'default' && (params.term == '' || !params.term)) {
                        dtObject.hideViewActions(current.data('target-table'));
                    }else{
                        dtObject.showViewActions(current.data('target-table'));
                    }

                    return {
                        id: params.term,
                        text: params.term + " (" + _t('New') + ")",
                    }
                }
            });

            if(savedParams.hasOwnProperty('last_used_view') && (!initTableOptions.hasOwnProperty('ignoreLocalStorage') || !initTableOptions.ignoreLocalStorage) ) {
                current.val(savedParams.last_used_view);
                current.trigger('change', true);
            }

            let $selectedOption = current.find(":selected");

            if($selectedOption.length && $selectedOption.data('default')) {
                dtObject.hideViewActions(current.data('target-table'));
            }
        });

        select2CreateTag.on('select2:close', function (evt) {
            let current = $(this);
            let $selectedOption = $(this).find(":selected");

            if(current.val() == 'default' || $($selectedOption).data('default')) {
                dtObject.hideViewActions(current.data('target-table'))
            }
        });

        select2CreateTag.on('change', function (evt, autoTriggered) {
            let $selectedOption = $(this).find(":selected");
            let params = $selectedOption.attr('data-view-params') ? JSON.parse($selectedOption.attr('data-view-params')) : [];
            let targetTableID = $(this).data('target-table');
            let $targetTable = $('#' + targetTableID);
            let viewName = $(this).val();
            let savedParams = localStorage.hasOwnProperty(targetTableID) ? JSON.parse(localStorage.getItem(targetTableID)) : [];

            dtObject.toggleViewInfoMessage(targetTableID, 'none');

            savedParams.last_used_view = viewName;
            localStorage.setItem(targetTableID, JSON.stringify(savedParams));

            if(viewName == 'default' || $($selectedOption).data('default')) {
                dtObject.hideViewActions(targetTableID);
            }else{
                dtObject.showViewActions(targetTableID);
            }

            if( (!params || _.isEmpty(params)) && viewName != 'default' ) {
                dtObject.toggleViewInfoMessage(targetTableID, 'initial');
                return;
            }else if(autoTriggered) {
                $($selectedOption).data('default');
                return;
            }else if(viewName == 'default') {
                dtObject.resetColumnsVisibility(targetTableID);
                dtObject.resetFilters(targetTableID);
                return;
            }

            let newParams = $.extend(true, {}, savedParams, params);
            newParams.order = params.order;
            localStorage[targetTableID] = JSON.stringify(newParams);

            for(let vc in params.visibleCols) {
                let columnTarget = params.visibleCols[vc].column_target;
                let visible = params.visibleCols[vc].visible;
                let checkbox = $('input[type="checkbox"][data-table_target="' + targetTableID + '"][data-column_target="' + columnTarget + '"]');

                if(visible == 'false' || visible == false) {
                    checkbox.prop('checked', false).iCheck('update');
                }else{
                    checkbox.prop('checked', true).iCheck('update');
                }
            }

            dtObject.resetFiltersInputs(targetTableID);

            if($.fn.dataTable.isDataTable($targetTable)){
                $targetTable.off('draw');
                $targetTable.off('preDraw');
                $targetTable.DataTable().destroy();
            }

            dtObject.draw($targetTable, true);
        });

        saveBtns.on('click', function () {
            let current = $(this);
            let selectTargetID = current.data('target-select');
            let selectTarget = $('#' + selectTargetID);
            let viewName = selectTarget.val();
            let targetTableID = current.data('target-table');
            let saveRoute = current.data('save-route');

            if(!viewName) {
                swal({
                    text: window.viewNameRequiredTrans,
                    type: "error",
                    showCancelButton: false,
                });

                return;
            }

            let savedParams = localStorage.hasOwnProperty(targetTableID) ? JSON.parse(localStorage.getItem(targetTableID)) : null;

            $.ajax({
                method: 'POST',
                url: saveRoute,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.content
                },
                data: {
                    target_table: targetTableID,
                    table_params: savedParams,
                    view_name: viewName,
                },
                success: function (res) {
                    let selectsToAppend = $('.select2-create_tag[data-target-table="' + targetTableID + '"]');
                    selectsToAppend.find('option[data-select2-tag="true"]').remove();

                    selectsToAppend.each(function () {
                        let $this = $(this);
                        if( !$this.find('option[value="' + viewName + '"]').length ) {
                            let newOption = new Option(viewName, viewName, true, true);
                            selectsToAppend.append(newOption);
                            selectsToAppend.val(viewName);
                            selectsToAppend.trigger('change', true);
                        }

                        $this.find('option[value="' + viewName + '"]').attr('data-view-params', JSON.stringify(savedParams));
                    });

                    dtObject.toggleViewInfoMessage(targetTableID, 'none');
                    $('.' + targetTableID + 'FiltersAlert').css('display', 'none');

                    swal({
                        text: res.message,
                        type: "success",
                        showCancelButton: false,
                    });
                },
                error: function (err) {

                }
            });

        });

        deleteBtns.on('click', function () {
            let current = $(this);
            let selectTargetID = current.data('target-select');
            let selectTarget = $('#' + selectTargetID);
            let viewName = selectTarget.val();
            let targetTableID = current.data('target-table');
            let deleteRoute = current.data('delete-route');

            if(!viewName) {
                swal({
                    text: window.viewNameRequiredTrans,
                    type: "error",
                    showCancelButton: false,
                });

                return;
            }

            swal({
                text: _t('Are you sure you want to remove the selected table view?'),
                type: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                cancelButtonText: _t('Cancel'),
                cancelButtonClass: "btn btn-default",
                confirmButtonText: _t('Delete'),
                confirmButtonClass: "btn btn-danger",
            }).then(function(result) {
                if(result.value) {
                    $.ajax({
                        method: 'POST',
                        url: deleteRoute,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': token.content
                        },
                        data: {
                            target_table: targetTableID,
                            view_name: viewName,
                            _method: 'DELETE',
                        },
                        success: function (res) {
                            let selectsToRemove = $('.select2-create_tag[data-target-table="' + targetTableID + '"]');

                            selectsToRemove.find('option[value="' + viewName + '"]').remove();
                            selectsToRemove.val(selectsToRemove.find('option:first').val());
                            selectsToRemove.trigger('change', true);
                            selectTarget.trigger('change');
                            dtObject.hideViewActions(targetTableID);

                            swal({
                                text: res.message,
                                type: "success",
                                showCancelButton: false,
                            });
                        },
                        error: function (err) {

                        }
                    });
                }
            });
        })
    }
}
