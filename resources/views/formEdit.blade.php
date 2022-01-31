<script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<form method="post" id="fm">
    <table class="table table-condensed" border="0" cellpadding="0" cellspacing="12">
        <tr>
            <td>Tanggal</td>
            <td>: <input name="tanggal" value="{{ date('d-m-Y', strtotime($clients->first()->tanggal)) }}"
                    id="tanggal" placeholder="Tanggal"></label></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <input name="nama" value="{{ $clients->first()->nama }}" id="name" placeholder="Nama"></label></td>
        </tr>
    </table>
    <table class="table" id="tblItem">
        <thead>
            <tr id="header_cart">
                <th>No</th>
                <th>Jobdesk</th>
                <th>Hobi</th>
                <th>Harga Hobi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=0;
            foreach($jobdesk as $job):
                $no++;
                ?>
            <tr>
                <td>
                    <span class="tblItem_num"><?= $no ?></span>
                </td>
                <td>
                    <input name="jobdesk[]" id="jobdesk" value="{{ $job->jobdesk }}">
                </td>
                <td>
                    <input id="hobi" name="hobi[]" value="{{ $job->hobi }}">
                </td>
                <td>
                    <input id="hargaHobi" name="hargaHobi[]" class="auto-numeric im-currency" value="{{ $job->hargaHobi }}" style="text-align: right">
                </td>
                <td>
                    <span class="delete_btn">
                        <a href="javascript:;" onclick="del_row(this,'tblItem_del')" class="tblItem_del"><span
                                class="ui-icon ui-icon-trash"></span></a>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Totals:</td>
                @foreach($totalHarga as $totals)
				<td>
                <input id="total" name="total[]" disabled class="auto-numeric input-offer" value="{{ $totals->total }}" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;">
                </td>
                @endforeach
                <td>
                    <a href="javascript:;" onclick="add_row('tblItem')"><span class="ui-icon ui-icon-plus"></span></a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>

<script>
    function add_row(table_id) {
        var row = $('table#' + table_id + ' tbody tr:last').clone();
        $("span." + table_id + "_num:first").text('1');
        var n = $("span." + table_id + "_num:last").text();
        var no = parseInt(n);
        var c = no + 1;
        $('table#' + table_id + ' tbody tr:last').after(row); // buat looping
        $('table#' + table_id + ' tbody tr:last input').val("");
        $('table#' + table_id + ' tbody tr:last input.datepicker').removeAttr('id').removeClass("hasDatepicker")
            .datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true
            });;
        $('table#' + table_id + ' tbody tr:last input.datepicker_exp').removeAttr('id').removeClass("hasDatepicker")
            .datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true
            });;
        $('table#' + table_id + ' tbody tr:last div').text("");
        $('table#' + table_id + ' tbody tr:last span.span_clear').text("");
        $("span." + table_id + "_num:last").text(c);
        console.log($('.auto-numeric').autoNumeric('destroy'))
        $("#hargaHobi.auto-numeric").bind('keyup', function(event) {
            let total = 0;
            $('#hargaHobi.auto-numeric').each(function(index, element) {
                total = total + parseFloat($(element).autoNumeric("get") == "" ? 0 : $(element)
                    .autoNumeric("get"));
            });
            $("#total").autoNumeric('set', total);
        });
        $('.auto-numeric').autoNumeric('init', {
            'aSep': '.',
            'aDec': ',',
            'vMin': '0',
            'vMax': '999999999999'
        });
    }

    function del_row(dis, conname) {
        if ($('.' + conname).length > 1) {
            var jwb = confirm('Anda Yakin ?');
            if (jwb == 1) {
                $(dis).parent().parent().parent().remove();
                let total = 0;
                $('#hargaHobi.auto-numeric').each(function(index, element) {
                    total = total + parseFloat($(element).autoNumeric("get") || 0);
                });
                $("#total").autoNumeric('set', total);
                $("select.offeringid option:not([id=disabled])").removeAttr('disabled');
                $("select.offeringid").each(function(i, s) {
                    $("select.offeringid").not(s).find("option[value=" + $(s).val() + "]").attr('disabled', '');
                });
                $("select.offeringid").change(function(e) {
                    $("select.offeringid option:not([id=disabled])").removeAttr('disabled');
                    $("select.offeringid").each(function(i, s) {
                        $("select.offeringid").not(s).find("option[value=" + $(s).val() + "]").attr(
                            'disabled', '');
                    });
                });
            }
        } else {
            $.messager.alert('Peringatan', 'Tidak bisa hapus', 'warning');
        }
    }

    $(document).ready(function() {
        $('#tanggal').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            })
            .inputmask('dd-mm-yyyy');
    });

    $('.ui-dialog-titlebar-close').html('<span class="ui-button-icon ui-icon ui-icon-closethick"></span>');

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
</script>
