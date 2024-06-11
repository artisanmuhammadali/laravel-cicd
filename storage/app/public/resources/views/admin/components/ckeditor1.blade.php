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
            id: true,
            styles: true
        }
    ]
},
heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
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
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                Authorization: 'Bearer '
            }
        }

	} )
	.then( editor => {
        window.editor = editor;
        // Listen for the paste event in CKEditor
        editor.editing.view.document.on('paste', (evt, data) => {
            // Prevent the default paste behavior
            // evt.stop();
            // Get the pasted content
            const pastedContent = data.dataTransfer.getData('text/html');
            // Switch CKEditor to source mode
            editor.sourceElement.innerHTML = pastedContent;
        });
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