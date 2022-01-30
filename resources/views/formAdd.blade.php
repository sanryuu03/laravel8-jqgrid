<script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<form method="post" id="fm">
	<table class="table table-condensed" border="0" cellpadding="0" cellspacing="12">
		<!-- <tr>
            <td>Client ID</td>
            <td>: <input name="client_id"  required="true" id="client_id" placeholder="Client ID"></td>
        </tr> -->
		<tr>
			<td>Tanggal</td>
			<td>: <input name="tanggal" required="true" id="tanggal" placeholder="dd-mm-yyyy"></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>: <input name="nama" required="true" id="nama" placeholder="Nama"></td>
		</tr>
	</table>
	<table class="table" id="tblItem">
		<thead>
			<tr id="header_cart">
				<th>No</th>
				<th>Jobdesk</th>
				<th>Hobi</th>
				<th>hargaHobi</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>
					<span class="tblItem_num">1</span>
				</td>
				<td>
					<input name="jobdesk[]" id="jobdesk" type="text">
				</td>
				<td>
					<input id="hobi" name="hobi[]" required="" >
				</td>
				<td>
				<!-- <input id="hargaHobi" name="hargaHobi[]" required="" class="auto-numeric input-offer im-currency" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;width: 110px;"> -->
					<input id="hargaHobi" name="hargaHobi[]" required="" class="auto-numeric im-currency" style="text-align: right">
				</td>
				<td>
					<span class="delete_btn">
						<a href="javascript:;" onclick="del_row(this,'tblItem_del')" class="tblItem_del"><span
								class="ui-icon ui-icon-trash"></span></a>
					</span>
				</td>
			</tr>
		</tbody>
		<tfoot>
            <tr>
                <td colspan="3">Totals:</td>
				<td>
                <input id="total" name="total[]" disabled class="auto-numeric input-offer" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;width: 160px;">
                </td>
                <td>
                    <a href="javascript:;" onclick="add_row('tblItem')"><span class="ui-icon ui-icon-plus"></span></a>
                </td>
            </tr>
        </tfoot>
	</table>
</form>

<script>
function add_row(table_id)
	{
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		var no = parseInt(n);
		var c = no + 1;
		$('table#'+table_id+' tbody tr:last').after(row); // buat looping
		$('table#'+table_id+' tbody tr:last input').val("");
		$('table#'+table_id+' tbody tr:last input.datepicker').removeAttr('id').removeClass("hasDatepicker").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth:true});;
		$('table#'+table_id+' tbody tr:last input.datepicker_exp').removeAttr('id').removeClass("hasDatepicker").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth:true});;
		$('table#'+table_id+' tbody tr:last div').text("");
		$('table#'+table_id+' tbody tr:last span.span_clear').text("");
		$("span."+table_id+"_num:last").text(c);
		console.log($('.auto-numeric').autoNumeric('destroy'))
		$("#hargaHobi.auto-numeric").bind('keyup', function(event) {
		let total = 0;
		$('#hargaHobi.auto-numeric').each(function (index, element) {
			total = total + parseFloat($(element).autoNumeric("get")==""?0:$(element).autoNumeric("get"));
		});
		$("#total").autoNumeric('set',total);
		});
		$('.auto-numeric').autoNumeric('init', {
			'aSep': '.',
			'aDec': ',',
			'vMin': '0',
			'vMax': '999999999999'
		});
	}

function del_row(dis, conname)
	{
		if($('.'+conname).length > 1)
			{
				var jwb = confirm('Anda Yakin ?');
				if (jwb==1)
				{
					$(dis).parent().parent().parent().remove();
					let total = 0;
					$('#hargaHobi.auto-numeric').each(function (index, element) {
						total = total + parseFloat($(element).autoNumeric("get")||0);
					});
					$("#total").autoNumeric('set',total);
					$("select.offeringid option:not([id=disabled])").removeAttr('disabled');
					$("select.offeringid").each(function(i,s){
						$("select.offeringid").not(s).find("option[value="+$(s).val()+"]").attr('disabled','');
					});
					$("select.offeringid").change(function(e){
						$("select.offeringid option:not([id=disabled])").removeAttr('disabled');
						$("select.offeringid").each(function(i,s){
							$("select.offeringid").not(s).find("option[value="+$(s).val()+"]").attr('disabled','');
						});
					});
				}
			}
		else
			{
				$.messager.alert('Peringatan','Tidak bisa hapus','warning');
			}
	}
</script>
<script>
$(document).ready(function() {
$('#tanggal').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        })
.inputmask('dd-mm-yyyy');
});

$('.ui-dialog-titlebar-close').html('<span class="ui-button-icon ui-icon ui-icon-closethick"></span>');

$("#hargaHobi.auto-numeric").bind('keyup', function(event)
	{
		let total = 0;
		$('#hargaHobi.auto-numeric').each(function (index, element)
		{
			total = total + parseFloat($(element).autoNumeric("get")==""?0:$(element).autoNumeric("get"));
		});
		$("#total").autoNumeric('set',total);
	});
$('.auto-numeric').autoNumeric('init', {
    'aSep': '.',
    'aDec': ',',
    'vMin': '0',
    'vMax': '999999999999'
});
</script>
