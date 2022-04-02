function somenteNumeros(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    // charCode 8 = backspace   
    // charCode 9 = tab
    if (charCode != 8 && charCode != 9) {
        // charCode 48 equivale a 0   
        // charCode 57 equivale a 9
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function chamarAlerta() {
    $('.alert-1').toggle("slow");
    setTimeout(function() {
        $('.alert-1').toggle("slow");
    }, 3000);
};

function chamarAlertaNormal() {
    $('.alert').toggle("slow");
    setTimeout(function() {
        $('.alert').toggle("slow");
    }, 3000);
};

function excluir() {
    $('.excluir').toggle("slow");

};

function chamarAlertaMg() {
    $('.msg').toggle("slow");
    setTimeout(function() {
        $('.msg').toggle("slow");
    }, 3000);
};

function chamarAlertaBuscaCliente() {
    $('.buscaCliente').toggle("slow");
    setTimeout(function() {
        $('.buscaCliente').toggle("slow");
    }, 3000);
};

function chamarAlertaSelecionaCliente() {
    $('.selecionaCliente').toggle("slow");
    setTimeout(function() {
        $('.selecionaCliente').toggle("slow");
    }, 3000);
};

function reciboContBaixadas() {
    $('.reciboContBaixadas').toggle("slow");
    setTimeout(function() {
        $('.reciboContBaixadas').toggle("slow");
    }, 3000);
};

function recibo() {
    $('#reciboContasBaixadas').modal();
}

function tabenter(event, campo) {
    var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (tecla == 13) {
        campo.select();
    }

};

function setarFoco(campo) {

    document.getElementById(campo).select();

}

function moeda(a, e, r, t) {
    let n = "",
        h = j = 0,
        u = tamanho2 = 0,
        l = ajd2 = "",
        o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o), -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
        h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
    ;
    for (l = ""; h < u; h++)
        -
        1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
        for (ajd2 = "",
            j = 0,
            h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
                j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
            tamanho2 = ajd2.length,
            h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}