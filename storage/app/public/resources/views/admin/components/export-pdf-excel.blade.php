{{-- download data in pdf --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
    var timeout = null;
    document.getElementById('downloadPdf').addEventListener('click', function () {
        window.scrollTo(0, 0);
        var element = $('.downloadBody').html();
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            html2pdf(element ,{
                filename:     'test.pdf'
            });
        return true;
        }, 500)
    });
    function openPdfModal(type , json)
    {
        var url = '{{route('admin.mtg.crm.export')}}'
        $.ajax({
            type: "GET",
            data: {
                type: type,
                json: json,
            },
            url: url,
            success: function (response) {
                $('.modal-title').text(convertToTitleCase(type));
                $('.exportDataTable').html(response.html);
                $('.downloadPdfModal').modal('show');
            },
        });
    }
    function convertToTitleCase(str) {
        return str
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }
</script>
{{-- download data in excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>
<script>
    $(document).on('click','.downloadData',function(){
        var type = $(this).attr('data-type');
        var data = $('#'+type).val();
        data =JSON.parse(data);
        data = Object.values(data)
        if($(this).hasClass('downloadPdf'))
        {
            openPdfModal(type , data)
        }
        else
        {
            
            jsonToExcel(data , type)
        }
    })
    function jsonToExcel(jsonData, fileName) {
        // const jsonDatasString = jsonData;
        // const jsonDatas = JSON.parse(jsonDatasString);
        // console.log(jsonDatas)
        const worksheet = XLSX.utils.json_to_sheet(jsonData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

        // Generate a file in binary format
        const excelData = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });

        // Convert the binary data to a Blob
        const blob = new Blob([s2ab(excelData)], { type: 'application/octet-stream' });

        // Create a download link and trigger the download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName + '.xlsx';
        document.body.appendChild(a);
        a.click();

        // Clean up
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }
    // Convert string to ArrayBuffer
    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }

</script>