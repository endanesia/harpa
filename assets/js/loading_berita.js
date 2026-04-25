//var myVarBerita = setInterval(load_berita,10000);
function load_berita(url){
    if(getCookie("showup_news")!=""){
        if(getCookie("showup_news")=="tampil"){
            $.ajax({
                url       : url,
                type      : 'GET',
                beforeSend: function(){
                        ///Event sebelum proses data dikirim
                        // $("#ajax_loader").fadeIn(100);
                },
                success   : function(data){
                        ///Event Jika data Berhasil diterima
                        obj = JSON.parse(data);
                         $("#ajax_loader").fadeOut(100);
                        if(obj.status=="OK"){
                            $.confirm({
                                title: 'Informasi/Berita',
                                content: obj.berita,
                                closeIcon: true, closeIconClass: 'fa fa-close',
                                columnClass: 'col-lg-7 col-md-8 col-sm-12 w-100',
                                containerFluid: true,
                                useBootstrap:true,
                                type: 'dark', typeAnimated: true, draggable: true,
                                buttons: {
                                    tryAgain: {
                                        text: 'Jangan tampil lagi',
                                        btnClass: 'btn-red',
                                        action: function(){
                                            createCookie("showup_news","tutup", 0.3);
                                        }
                                    },
                                    keluar: {
                                        text: 'Keluar',
                                        btnClass: 'btn-blue'
                                    }
                                }
                            });
                        }
                }
            });///end Of Ajax
        }

    }else{
        createCookie("showup_news","tampil", 0.6);
    }

}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
