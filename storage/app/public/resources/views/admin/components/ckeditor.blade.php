<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        var nextPage = '{{ $page_content2??0 }}';

        CKEDITOR.dtd.a.div = 1;
        CKEDITOR.dtd.a.p = 1;
        CKEDITOR.dtd.$removeEmpty.span = 0;
        CKEDITOR.dtd.$removeEmpty.i = 0;
        CKEDITOR.config.allowedContent = true;

        // CKEDITOR.config.extraAllowedContent = '*{*}';
        CKEDITOR.replaceAll('ckeditor', {
            height: 800,
            // baseFloatZIndex: 10005,
            removeButtons: 'PasteFromWord',
            extraPlugins: 'lineheight',
        });
        // CKEDITOR.replaceAll('ckeditor', {
        //     height: 400,
        //     // baseFloatZIndex: 10005,
        //     removeButtons: 'PasteFromWord',
        //     extraPlugins: 'lineheight',
        // });

        CKEDITOR.config.contentsCss = [CKEDITOR.config.contentsCss,
            '{{asset('css/custom.css')}}',
            'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
        ];

    </script>
