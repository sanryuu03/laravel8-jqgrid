<script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<form method="post" id="fm" >
    <table class="table table-condensed" border="0" cellpadding="0" cellspacing="12">
        <tr>
            <td>Tanggal</td>
            <td>: <input name="tanggal" disabled="disabled" value="{{ date('d-m-Y', strtotime($clients->first()->tanggal)) }}" id="tanggal" placeholder="Tanggal"></label></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <input name="nama" disabled="disabled" value="{{ $clients->first()->nama }}" id="name" placeholder="Nama"></label></td>
        </tr>
    </table>
    <table class="table" id="tblItem">
        <thead>
            <tr id="header_cart">
                <th>No</th>
                <th>Jobdesk</th>
                <th>Hobi</th>
                <th>Harga Hobi</th>
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
                        <input name="jobdesk[]" disabled="disabled" id="jobdesk" value="{{ $job->jobdesk }}" >
                    </td>
                    <td>
                        <input id="hobi" name="hobi[]" disabled="disabled" value="{{ $job->hobi }}">
                    </td>
                    <td>
                        <input id="hargaHobi" name="hargaHobi[]"  disabled="disabled" value="{{ number_format($job->hargaHobi , 0, ',', '.') }}" style="text-align: right;width: 110px;">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Totals:</td>
                @foreach($totalHarga as $totals)
				<td>
                {{-- <input id="total" name="total[]" disabled class="auto-numeric input-offer" value="{{ $totalHarga[totals]->total }}" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;width: 110px;"> --}}
                {{-- <input id="total" name="total[]" disabled class="auto-numeric input-offer" value="{{ json_encode($totalHarga->total) }}" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;width: 110px;"> --}}
                <input id="total" name="total[]" disabled class="auto-numeric input-offer" value="{{ $totals->total }}" type="text" aria-describedby="amount" data-v-max="5000000000" data-v-min="0" data-a-sep="." data-a-dec="," style="text-align: right;width: 110px;">
                </td>
                @endforeach
            </tr>
        </tfoot>
    </table>
</form>


<script>
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
