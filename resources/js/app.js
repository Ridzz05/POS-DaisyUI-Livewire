import "./bootstrap";

//function to print
function cetakStruk(url) {
    const showPrint = window.open(url, "_blank", "width=400,height=600");

    //show print
    showPrint.addEventListener("load", () => {
        showPrint.print();
        //function after print, close page
        showPrint.addEventListener("afterprint", () => {
            showPrint.close();
        });
    });

    return false;
}

window.cetakStruk = cetakStruk;
