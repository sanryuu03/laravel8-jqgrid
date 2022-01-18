<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- laravel wajib tambahkan ini  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- jika tidak ada csrf-token maka localhost tidak akan muncul --}}
    {{-- karna localhost method post sedangkan tampilMaster method get --}}
    {{-- sehingga di reoutenya menjadi match --}}
    <title>{{ $title }}</title>

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.8.0/css/ui.jqgrid.css">
  <link rel="stylesheet" href="{{ asset('css/jquery-ui-1.10.4.custom.min.css') }}">
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/cupertino/jquery-ui-1.10.4.custom.min.css') }}"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        .highlight {
        /* background-color: #EEF43B; */
        background-color: #00BFFF;
        }

        .ui-tabs-anchor {
            font-size: 13.5px;
        }

        .judul {
            display: block;
            font-size: 1.5em;
            margin-block-start: 0.83em;
            margin-block-end: 0.83em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .ui-jqgrid-btable.ui-common-table {
            font-size: 13px;
            text-transform: uppercase;
            /*font-style: italic;*/
        }

        tr {
            font-size: 12px;
        }

        #gs_nama {
            height: 26px;
            font-size: 12px;
            width: 95%;
            border-radius: 0;
            /*font-weight: unset;*/
            font-style: unset;
        }

        /* ini buat atur size  kotak search */
        #gs_tanggal {
            height: 26px;
            font-size: 12px;
            width: 95%;
            border-radius: 0;
            /*font-weight: unset;*/
            font-style: unset;
        }

        #gs_clientID {
            height: 26px;
            font-size: 12px;
            width: 95%;
            border-radius: 0;
            font-style: none;
        }

        table.ui-pg-table.navtable.ui-common-table {
            margin-right: 480px;
        }

        .ui-tabs-anchor {
            font-size: 13.5px;
        }

        span.ui-button-icon-primary.ui-icon.ui-icon-closethick {
            margin-top: 10px;
        }

        .ui-button-icon-space #text {
            display: none;
        }

        button .ui-button .ui-corner-all .ui-widget .ui-button-icon-only .ui-dialog-titlebar-close {
            text-decoration: none;
            display: none;
            margin-left: 10px;
        }

        #resetdatafilter.active {
            background-color: #d44d24;
            color: #080808;
        }

        #resetdatafilter:hover {
            background-color: #34d4f7;
            color: #ffffff;
            border: 1px solid #000000;
        }

        td.ui-search-clear {
            width: 25px;
        }

        td.ui-pg-button.ui-corner-all:hover {
            border-radius: 0;
        }

        #tabs {
            border-radius: 0;
        }

        .ui-jqgrid.ui-widget.ui-widget-content.ui-corner-all {
            border-radius: 0;
        }

        #plist48 {
            border-radius: 0;
        }

        .ui-tabs-nav.ui-corner-all.ui-helper-reset.ui-helper-clearfix.ui-widget-header {
            border-radius: 0;
        }
        @-moz-document url-prefix() {
            #gs_name {
                font-weight: unset;
            }

            #gs_client_id {
                font-weight: unset;
            }

            .ui-jqgrid tr.jqgrow td {
                height: 25px;
            }
        }
    </style>
</head>

<body>
    @yield('menuContent')
</body>

    <script src="{{ asset('js/jquery.min.js') }}" type="text/ecmascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ url('js/i18n/grid.locale-en.js') }}" type="text/ecmascript"></script>
    <script src="{{ asset('js/530/js/trirand/jquery.jqGrid.min.js') }}" type="text/ecmascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('js/autoNumeric.js') }}"></script>
    <script src="{{ asset('js/highlight.js') }}"></script>

    <script src="{{ asset('js/script.js') }}"></script>
</html>
