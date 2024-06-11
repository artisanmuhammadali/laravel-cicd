<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
var timeout = null;
    $(document).on('click','.downloadPdf', function () {
        var file = $(this).attr('data-file');
        var div = $(this).attr('data-class');
        console.log(div , file);
        window.scrollTo(0, 0);
        var element = $('.'+div).html();
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            html2pdf(element ,{
                filename:     file
            });
        return true;
        }, 500)
    });
</script>