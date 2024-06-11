<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="magic the gathering, card market, mtg, trading cards, very friendly sharks, vfs mtg, vfs uk, vfs, magic the gathering cards, magic card market, magic singles, mtg cards, mtg singles uk, uk mtg singles, sell mtg cards uk, buy mtg cards uk">
    <meta name="description" content="@yield('description')">
    @yield('metaTag')
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    @stack('css')
    <style>
        .ck-editor__editable {
    height: 400px; /* Set your desired height here */
}
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('ckk/sample/styles.css')}}"> -->
</head>

<body class="font-sans antialiased">
            @yield('content')
            <script src="{{asset('ckk/build/ckeditor.js')}}"></script>
            <!-- <script src="{{asset('ckk/sample/script.js')}}"></script> -->
<script>
    ClassicEditor
	.create( document.querySelector( '.editor' ), {
        htmlSupport: {
    allow: [
        {
            name: /.*/,
            attributes: true,
            classes: true,
            styles: true
        }
    ]
},

        contentCss: [
            '{{asset('css/custom.css')}}',
            'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
        ],
        simpleUpload: {
            uploadUrl: '{{route('admin.mtg.cms.pages.ckeditor.upload')}}',
            // Enable the XMLHttpRequest.withCredentials property.
            withCredentials: true,
            // Headers sent along with the XMLHttpRequest to the upload server.
            headers: {
                'X-CSRF-TOKEN': 'CSRF-Token',
                Authorization: 'Bearer <JSON Web Token>'
            }
        }

	} )
	.then( editor => {
        window.editor = editor;
	} )
	.catch( handleSampleError );

function handleSampleError( error ) {
	const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

	const message = [
		'Oops, something went wrong.',
		`Please, report the following error on ${ issueUrl } with the build id "parvgrg3s0h8-nohdljl880ze" and the error stack trace:`
	].join( '\n' );

	console.error( message );
	console.error( error );
}
</script>
</body>

</html>
