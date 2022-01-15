@extends('layouts.main')

@section('menuContent')
 <p>anda mengunjungi  {{  url('') }}</p>
 <form action="" method="post">
	<label for="">Global Search</label>
	<input type="search" id="globalSearch" style="width:250px" placeholder="Keyword..."/>
</form>

<script type="text/javascript">
	let operid = 0;
	let triggerClick = true;
	let sortName = "name";
	let postData;
	function loadData() {
		var url, oper;
		//Data Guru
		jQuery("#list1").jqGrid({
			url: '{{  url('sangrid/tampilMaster') }}',
			// mtype: "post",
			mtype: "get",
			datatype: "json",
			colNames: [
				'Client ID',
				'Tanggal',
				'Nama'
			],
			colModel: [{
					name: 'client_id',
					index: 'client_id',
					width: 15,
					key: true,
					editable: true,
					editrules : { required: true},
					editoptions : { required: true, placeholder: "Clients required"},
					// search: false,
					// searchoptions: {
					// 	sopt: ["cn"]
					// }
				},
                    {
						// label: 'tanggal',
                        name: 'tanggal',
						index: 'tanggal',
                        width: 30,
						editable: true,
						editrules : { required: true},
						// search: false,
						searchoptions: {
						sopt:"cn"
					}
                    },
				{
					name: 'name',
					index: 'name',
					width: 90,
					editable: true,
					editrules : { required: true},
					// searchoptions: {
					// 	// sopt:"cn",
					// 	// sopt:"eq",
					// 	// sopt:"gt",
					// 	// sopt:"lt",
					// 	// sopt:"ge",
					// 	// sopt:"le",
					// 	// sopt : ['eq','gt','lt','ge','le']
					// }
				},
			],


			sortable: true,
			// sortable untuk menggeser field client_id dan name
			pager: "#plist1",
			rowList: [5, 10, 50],
			height: 220,
			width: '1100',
			// autowidth: true,
			viewrecords: true,
			// sortname: "client_id",
			sortname : sortName,
			rownumbers: true,
			sortorder: "asc",
			// loadonce => jqgrid bisa request berkali kali (default: false) jika true tidak bisa pilih page
			// loadonce: true,
			// mtype: "POST",
			rowNum: 10,
			toolbar: [true, "top"],

			gridview: true,
			altclass: 'myAltRowClass',
			stringResult: false,
			enctype: 'multipart/form-data',

			onSelectRow: function(client_id, selected) {
				activeGrid = "#list1";
				operid = $(this).jqGrid("getCell", client_id, "rn") - 1;
				page = $(this).jqGrid("getGridParam", "page") - 1;
				rows = $(this).jqGrid("getGridParam", "postData").rows;
				if (operid >= rows) operid = operid - rows * page;
				if (client_id != null) {
					// var data = $("#list1").getRowData(client_id);
					let data = $("#list1").getRowData(client_id).client_id.replace(/(<([^>]+)>)/gi, "");
					// console.log(client_id);
				// return false;
					jQuery("#jqGridDetails").jqGrid('setGridParam', {
						url: '{{  url('sangrid/selectJqgrid') }}' + client_id, datatype: "json",
					});
					jQuery("#jqGridDetails").trigger("reloadGrid");
				}
				// operid = $(this).jqGrid("getCell", client_id, "client_id");
				console.log('ini operid',operid);
			},
			loadComplete: function()
			{
				postData = $(this).jqGrid("getGridParam", "postData");
				$(this).jqGrid('setSelection', operid);
				$("#" + $("#list1").getDataIDs()[operid]).click();
				// $("#list1").jqGrid('bindKeys');
				$(document).unbind("keydown");
				customBindKeys();
				console.log('ini halaman sekarang yaitu ' +$('#list1').getGridParam('page'));
				console.log('halaman terakhir yaitu ', $('#list1').getGridParam('lastpage'));
				console.log('limit halaman ', $('#list1').jqGrid("getGridParam", "postData").rows);
				// console.log($("#" + $("#list1").getDataIDs()[operid]));
				// const val = document.querySelector('name').value;
				// ambil nilai dari search name atau nama
				const val = document.getElementById('gs_name').value;
				const valClient = document.getElementById('gs_client_id').value;
				const valTanggal = document.getElementById('gs_tanggal').value;
				const valGlobalSearch = document.getElementById('globalSearch').value;
  				console.log('ini value input nama yaitu ' + val);
				$('[aria-describedby=list1_name]').highlight(val);
				$('[aria-describedby=list1_client_id]').highlight(valClient);
				$('[aria-describedby=list1_tanggal]').highlight(valTanggal);
				$('#list1 tbody tr td:not([aria-describedby=list1_rn])').highlight(valGlobalSearch);

				/*ini akses keyboard */
				// rowNum = $("#list1").jqGrid('getGridParam', 'rowNum');
                // ids = $("#list1").jqGrid('getDataIDs');
                // $('#list1').jqGrid('setSelection', ids[operid]);
				// $("#next_plist1").click();
				// $("#prev_plist1").click();
                // var index = 0
                // document.addEventListener("keydown", function(event) {
                    // if(event.which == 38){ //tombol atas
                    //     if(index != 0){
                    //         $('#list1').jqGrid('setSelection', ids[index = index-1]);
                    //     }
                    // }if(event.which == 40){ //tombol bawah
                    //     if(index != rowNum){
                    //         $('#list1').jqGrid('setSelection', ids[index = index+1]);
                    //     }
                    // }
                    // if(event.which == 35){ //End
					// 	$("#last_plist1").click();
                    // }
                    // if(event.which == 36){ //Home
					// 	$("#first_plist1").click();
                    // }
                // })
				/*ini batas akses keyboard */
			},
		});

		jQuery("#jqGridDetails").jqGrid({
			mtype: "get",
			datatype: "json",
			colNames: ['Jobdesk', 'Hobi', 'Harga Hobi'],
			colModel: [{
					name: 'jobdesk',
					index: 'jobdesk',
					width: 300,
					fixed: true,
					sortable: false,
					search: false,
				},
				{
					name: 'hobi',
					index: 'hobi',
					width: 300,
					fixed: true,
					sortable: false,
					search: false,
				},
				{
					name: 'harga_hobi',
					index: 'harga hobi',
					align: 'right',
					width: 200,
					fixed: true,
					sortable: false,
					search: false,
				},
			],

			footerrow: true,
			userDataOnFooter: true,
			sortable: true,
			width: 835,
			viewrecords: true,
			// sortname: "client_id",
			sortname: sortName,
			rownumbers: true,
			rowNum: 10,
			sortorder: "asc",
			loadonce: true,
			mtype: "POST",
			toolbar: [true, "top"],
			// caption: "JSON Example"
		});
		// Grid button CRUD
		$("#list1").navGrid('#plist1', {
			edit: false,
			add: false,
			del: false,
			view: false,
			search: false,
			refresh: false,
			position: "left",
			cloneToTop: false,
		}, );

		// Action button
		//button Add yg disebelah kiri bawah
		$('#list1').navButtonAdd('#plist1', {
				caption: "Add",
				title: "Add",
				id: "addclients",
				buttonicon: "ui-icon-plus",
				onClickButton: function() {
					AddClients();
				},
				position: 'first',
			})

			//button Delete yg disebelah kiri bawah
			.navButtonAdd("#plist1", {
				caption: "Delete",
				title: "Del",
				id: "delClients",
				buttonicon: "ui-icon-trash",
				onClickButton: function() {
					var client_id = $("#list1").jqGrid('getGridParam', 'selrow');
					if (client_id != null) {
						//alert(client_id);
						HapusClients(client_id);
					} else {
						alert("Pilih Row")
					}
				},
				position: 'fourth',
			})

			//button Edit yg disebelah kiri bawah
			.navButtonAdd("#plist1", {
				caption: "Edit",
				title: "Edit",
				id: "editClients",
				buttonicon: "ui-icon-pencil",
				onClickButton: function() {
					var client_id = jQuery("#list1").jqGrid('getGridParam', 'selrow');
					// console.log(client_id);
					// return false;
					if (client_id != null) {
						EditClients(client_id);
					} else {
						alert("Pilih Row")
					}
				},
				position: 'second',
			})

			//button View yg disebelah kiri bawah
			.navButtonAdd("#plist1", {
				caption: "View",
				title: "View",
				id: "viewClients",
				buttonicon: "ui-icon-document",
				onClickButton: function() {
					var client_id = jQuery("#list1").jqGrid('getGridParam', 'selrow');
					if (client_id != null) {
						//alert(client_id);
						DetailClients(client_id);
					} else {
						alert("Pilih row");
					}
				},
				position: 'third',
			})

			.navButtonAdd("#plist1", {
				caption: "Excel",
				title: "Excel",
				id: "excelClients",
				buttonicon: "ui-icon-print",
				onClickButton: function() {
					console.log('ini excel');
					location.href = "{{  url('sangrid/spreadSheet') }}";
				},
				position: 'fourth',
			})
			.navButtonAdd("#plist1", {
				caption: "Stimulsoft",
				title: "Stimulsoft",
				id: "StimulsoftClients",
				buttonicon: "ui-icon-script",
				onClickButton: function() {
					let baseUrl = "{{  url('') }}";
					console.log('ini Stimulsoft');
							$('#forminput').html(`
						<div class="ui-state-default" style="padding: 5px;">
							<h5> Tentukan Baris </h5>

							<label> Dari: </label>
							<input type="number" min="1" id="reportStart" name="start" value="${$(this).getInd($(this).getGridParam('selrow'))}" class="ui-widget-content ui-corner-all autonumeric" style="padding: 5px; text-transform: uppercase;" required>

							<label> Sampai: </label>
							<input type="number" id="reportLimit" name="limit" value="${$(this).getGridParam('records')}" class="ui-widget-content ui-corner-all autonumeric" style="padding: 5px; text-transform: uppercase;" required>
						</div>
					`)
					.dialog({
						width   : 'auto',
						height  : 250,
						position: 'top',
						modal   : true,
						title   : "Report",
						buttons: {
							Report: function () {
								let start = $(this).find("input[name=start]").val();
								let limit = $(this).find("input[name=limit]").val();
								let params;

								if (parseInt(start) > parseInt(limit)) {
									return alert("Sampai harus lebih besar");
								}

								for (var key in postData) {
									if (params != "") {
										params += "&";
									}
									params += key + "=" + encodeURIComponent(postData[key]);
								}
								window.open(
									baseUrl +
										`/sangrid/StimulsoftM?${params}&start=${start}&limit=${limit}&orders_sidx=${postData.sidx}&orders_sord=${postData.sord}`
								);
							},
							Cancel: function () {
								activeGrid = "#customer";
								$(this).dialog("close");
							},
						},
					});
				},
				position: 'fourth',
			})

			.navButtonAdd('#plist1', {
        caption: "xlsx",
        title: "xlsx",
		// id: "xlsx",
        buttonicon: "glyphicon glyphicon-file",
        position: "last",
        onClickButton: function () {
			let baseUrl = "{{  url('') }}";
            $('#forminput').html(`
                <div class="ui-state-default" style="padding: 5px;">
                    <h5> Tentukan Baris </h5>

                    <label> Dari: </label>
                    <input type="number" min="1" id="reportStart" name="start" value="${$(this).getInd($(this).getGridParam('selrow'))}" class="ui-widget-content ui-corner-all autonumeric" style="padding: 5px; text-transform: uppercase;" required>

                    <label> Sampai: </label>
                    <input type="number" id="reportLimit" name="limit" value="${$(this).getGridParam('records')}" class="ui-widget-content ui-corner-all autonumeric" style="padding: 5px; text-transform: uppercase;" required>
                </div>
            `)
					.dialog({
						width   : 'auto',
						height  : 250,
						position: 'top',
						modal   : true,
						title   : "Xlsx",
						buttons: {
							Xlsx: function () {
								let start = $(this).find("input[name=start]").val();
								let limit = $(this).find("input[name=limit]").val();
								let params;

								if (parseInt(start) > parseInt(limit)) {
									return alert("Sampai harus lebih besar");
								}

								for (var key in postData) {
									if (params != "") {
										params += "&";
									}
									params += key + "=" + encodeURIComponent(postData[key]);
								}
								report('excel')
								// window.open(
								// 	baseUrl +
								// 		`/sangrid/spreadSheetM${params}&start=${start}&limit=${limit}&orders_sidx=${postData.sidx}&orders_sord=${postData.sord}`
								// );
								// window.open(baseUrl+'/sangrid/spreadSheetM'+'?'+'&start='+start+'&limit='+limit+'&sidx='+postData.sidx+'&sord='+postData.sord+'&type='+type)
							},
							Cancel: function () {
								activeGrid = "#customer";
								$(this).dialog("close");
							},
						},
					});
				},
				position: 'fourth',
			})

		// Filter atau search toolbar
		$('#list1').jqGrid('filterToolbar',{
			stringResult: false,
			searchOnEnter: false,
			autoSearch: false,
			searchOperators: false,
			defaultSearch: 'cn',
		});

		//Membuat Jarak tabbar dengan grid
		$(".ui-jqgrid-titlebar").hide();
		$('.ui-tabs .ui-tabs-panel').css("padding", "unset");
		$('#plist1').css("font-size", "small");
		$('#plist1_center').css("width", "unset");
		// $('td.ui-search-clear').css("position", "fixed");
		$('#list1').jqGrid("setSelection", operid);
		// tombol clear filter
		$("#gsh_list1_rn").append('<div><button id="clearBtnFilter" class="btn btn-danger">X</button></div>');
	}
	function customBindKeys() {
        $(document).keydown(function (e) {
            if (
                e.keyCode == 38 ||
                e.keyCode == 40 ||
                e.keyCode == 33 ||
                e.keyCode == 34 ||
                e.keyCode == 35 ||
                e.keyCode == 36
            ) {
                e.preventDefault();

                if (activeGrid !== undefined) {
                    var gridArr = $(activeGrid).getDataIDs();
                    var selrow = $(activeGrid).getGridParam("selrow");
                    var curr_index = 0;
                    var currentPage = $(activeGrid).getGridParam("page");
                    var lastPage = $(activeGrid).getGridParam("lastpage");
                    var row = $(activeGrid).jqGrid("getGridParam", "postData").rows;

                    for (var i = 0; i < gridArr.length; i++) {
                        if (gridArr[i] == selrow) curr_index = i;
                    }

                    switch (e.keyCode) {
                        case 33:
                            if (currentPage > 1) {
                                $(activeGrid)
                                    .jqGrid("setGridParam", { page: currentPage - 1 })
                                    .trigger("reloadGrid");
                            }
                            break;
                        case 34:
                            if (currentPage !== lastPage) {
                                $(activeGrid)
                                    .jqGrid("setGridParam", { page: currentPage + 1 })
                                    .trigger("reloadGrid");
                            }
							break;
                        case 35:
                            $("#last_plist1").click()
							break;
                        case 36:
                            $("#first_plist1").click()
							break;
                        case 38:
                            if (curr_index - 1 >= 0)
                                $(activeGrid)
                                    .resetSelection()
                                    .setSelection(gridArr[curr_index - 1]);
                            break;
                        case 40:
                            if (curr_index + 1 < gridArr.length)
                                $(activeGrid)
                                    .resetSelection()
                                    .setSelection(gridArr[curr_index + 1]);
                            break;
                    }
                }
            }
        });
    }
	// Validasi jika data kosong
	function validasi() {
		var status = true;
		$('#fm :input[required]:visible').each(function(index, element) {
			if ($(element).val().trim() == "") {
				status = false,
					alert($(element).attr('client_id') + " tidak boleh kosong");
				$(element).focus();
				return false;
			}
		})
		return status;
	}

	// proses simpan data

	function simpanDataClients() {
		$(this).ready(function() {
			let baseUrl = "{{  url('') }}";
			if (validasi()) {
				$.ajax({
					type: "POST",
					url:
						baseUrl +
						"/sangrid/insertJqgrid" +
						"/" +
						$('#list1').jqGrid("getGridParam", "postData").rows,
					data: $('#fm').serialize(),
					dataType: "JSON",
					success: function(data) {
						console.log('ini client id',data.operid);
						operid = data.operid;
						console.log('ini page', data.page);
						console.log('ini row', data.row);
						$('#forminput').dialog('close');
						selectedPage = data.page;
						setTimeout(function () {
						$('#list1').setGridParam({
							page: selectedPage
						}).trigger('reloadGrid');
						}, 50);
					},
				})
			}
		});
	}

	// proses hapus data
	function hapusDataClients() {
		if (validasi()) {
			return $.ajax({
				type: "POST",
				url: url,
				data: $('#fm').serialize(),
				datatype: "JSON",
				success: function(data) {
					$("#forminput").dialog('close');
					$('#list1').setGridParam({
						datatype: 'json'
					}).trigger('reloadGrid');

					// ini reload detail
					$("#jqGridDetails").setGridParam({
						datatype: 'json'
					}).trigger('reloadGrid');
				}
			})
		}
	}

	// proses update data
	function updateDataClients() {
		if (validasi()) {
			return $.ajax({
				type: "POST",
				url: url,
				data: $('#fm').serialize(),
				datatype: "JSON",
				success: function(data) {
					$('#forminput').dialog('close');
					$("#list1").setGridParam({
						datatype: 'json'
					}).trigger('reloadGrid');
				}

			})
		}
	}

	// dialog add guru
	function AddClients() {
		page = '{{  url('sangrid/formCreate') }}';
		$('#forminput').html('<img src="{{  asset('images/loading.gif') }}').load(page);
		$("#forminput").dialog({
			top: 10,
			modal: false,
			title: "Add Data",
			height: '400',
			width: '610',
			position: [0, 0],
			show: {
				effect: 'fade'
			},
			buttons: [{
				html: "<img class='icon' src='{{  asset('images/cancel.png') }}'>Cancel",
				click: function() {
					$(this).dialog('close');
				}
			}, {
				html: "<img class='icon' src='{{  asset('images/ok.png') }}'>Save",
				click: function() {
					simpanDataClients();
				}
			}]
		});
	}

	// dialog hapus guru
	function HapusClients(client_id) {
		page = '{{url('sangrid/formDelete/')}}' + client_id;
		$('#forminput').html('<img src="{{  asset('images/loading.gif') }}').load(page);
		$("#forminput").dialog({
			top: 10,
			modal: false,
			title: "Hapus Data",
			height: '450',
			width: '560',
			position: [0, 0],
			show: {
				effect: 'fade'
			},
			buttons: [{
					html: "<img class='icon' src='{{  asset('images/cancel.png') }}'>Cancel",
					click: function() {
						$(this).dialog('close');
					}
				},
				{
					html: "<img class='icon' src='{{  asset('images/delete.png') }}'>Delete",
					click: function() {
						url = '{{ url('sangrid/deleteJqgrid/') }}' + client_id;
						var jwb = confirm('Anda yakin ingin menghapus data ini ?');
						if (jwb == 1) {
							hapusDataClients();
						}
					}
				}
			]
		});
	}

	// dialog edit guru
	function EditClients(client_id) {
		page = '{{ url('sangrid/formEdit/') }}' + client_id;
		$('#forminput').html('<img src="{{  asset('images/loading.gif') }}').load(page);
		$("#forminput").dialog({
			top: 10,
			modal: false,
			title: "Edit Data",
			height: '450',
			width: '530',
			position: [0, 0],
			show: {
				effect: 'fade'
			},
			buttons: [{
				html: "<img class='icon' src='{{  asset('images/cancel.png') }}'>Cancel",
				click: function() {
					$(this).dialog('close');
				}
			}, {
				html: "<img class='icon' src='{{  asset('images/ok.png') }}'>Save",
				click: function() {
					url = '{{ url('sangrid/updateJqgrid/') }}' + client_id;
					updateDataClients();
				}
			}],
		});
	}
	function report(type) {
		let baseUrl = "{{  url('') }}";

		let start = document.getElementById('reportStart').value
		let limit = document.getElementById('reportLimit').value

		if (parseInt(start) > parseInt(limit)) {
			return alert('Nilai "Sampai" harus lebih besar')
		}

		var sidx   = $("#plist1").jqGrid('getGridParam','sortname');
		var sord   = $("#plist1").jqGrid('getGridParam','sortorder');
		// var filter = ($("#plist1").getGridParam("postData").filters ? $("#plist1").getGridParam("postData").filters : '');
		window.open(baseUrl+'/sangrid/spreadSheetM'+'?'+'&start='+start+'&limit='+limit+'&sidx='+postData.sidx+'&sord='+postData.sord+'&type='+type)
		// window.open(baseUrl+'/pelanggan/report?filter='+filter+'&start='+start+'&limit='+limit+'&sidx='+sidx+'&sord='+sord+'&type='+type)
		}

	// dialog detail
	function DetailClients(client_id) {
		page = '{{ url('sangrid/formDetail/') }}' + client_id;
		$('#forminput').html('<img src="{{  asset('images/loading.gif') }}').load(page);
		$("#forminput").dialog({
			top: 10,
			modal: false,
			title: "View Data",
			height: '450',
			width: '520',
			position: [0, 0],
			show: {
				effect: 'fade'
			},
			buttons: [{
				html: "<img class='icon' src='{{  asset('images/cancel.png') }}'>Cancel",
				click: function() {
					$(this).dialog('close');
				}
			}],
		});
	}
</script>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">CRUD</a></li>
	</ul>
	<!--  This will be my jqGrid control and pager -->
<table id="tblEmployees"></table>
<div id="pager"></div>
	<div id="tabs-1">
		<table id="list1"></table>
		<div id="plist1"></div>
		<div id="forminput"></div>
		<hr>
		<div id="detailsPlaceholder">
			<table id="jqGridDetails"></table>
			<div id="jqGridDetailsPager"></div>
		</div>
	</div>
</div>

@endsection
