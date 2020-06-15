$(document).ready(function () {
    var dt = $('.dt')

    if(dt.length > 0){

        $('.dt').dataTable({
            bSort: false, // Prevent autosort
            dom: 'Bfrtip',
            //lengthChange: false,
            lengthMenu: [
                [10, 25, 50, 75, 100, -1],
                ['10 rows', '25 rows', '50 rows', '75 rows', '100 rows', 'Show all']
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    titleAttr: 'Copy',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                }, {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        })
    }

    $('.no-enter input, .no-enter textarea').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    /* Password toggle */
    $('#password-toggle').change(function (e) {
        var target = document.getElementById('signup-pwd');
        target.type = target.type === "password"
            ? "text"
            : "password"
    })
})