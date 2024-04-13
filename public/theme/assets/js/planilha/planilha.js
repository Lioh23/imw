function exportReportToExcel() {
    var table = document.querySelector("table");
    var wb = XLSX.utils.table_to_book(table, {
        sheet: "Sheet JS"
    });
    var wbout = XLSX.write(wb, {
        bookType: 'xlsx',
        bookSST: true,
        type: 'binary'
    });

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }

    saveAs(new Blob([s2ab(wbout)], {
        type: "application/octet-stream"
    }), 'relatorio.xlsx');
}