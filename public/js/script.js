// let keyword = document.getElementById('cariSangrid');
// keyword.addEventListener('keyup', function()
// {
//     console.log('ok');
// });
$(document).ready(function () {
    let bersihkan = document.getElementById('clearBtnFilter');
    bersihkan.addEventListener('click', function () {
        console.log('ok ini tombol X merah');
        var grid = $("#list1");
        grid.jqGrid('setGridParam', { search: false });
        var postData = grid.jqGrid('getGridParam', 'postData');
        $("#globalSearch").val("");
        $.extend(postData, { cariSangrid: "" });
        // ini untuk nimpa value di search name
        $('[id*="gs_"]').val('')
        // console.log($('[id*="gs_"]'))
        // for singe search you should replace the line with
        // $.extend(postData,{searchField:"",searchString:"",searchOper:""});
        // ini code untuk trigger tombol silang di search name
        // document.querySelector(".clearsearchclass").click()
        // atau 
        $(".clearsearchclass").click();
        $('#list1').setGridParam({
            datatype: 'json'
        }).trigger('reloadGrid');
        // grid.trigger("reloadGrid");
    });
   
    $('#globalSearch').on('keyup', function () {
        $('#list1').setGridParam({
            postData: {
                cariSangrid: $(this).val()
            }
        }).trigger('reloadGrid');
    })
    
});