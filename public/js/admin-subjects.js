document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('subjectFilterForm');

    const searchInput =
        document.querySelector('input[name="search"]');

    const departmentFilter =
        document.querySelector('select[name="department_id"]');

    const statusFilter =
        document.querySelector('select[name="status"]');


    if (!form) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH TEXT WATCHER
    |--------------------------------------------------------------------------
    */

    let searchTimer = null;

    if (searchInput) {

        searchInput.addEventListener('input', function () {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {

                form.submit();

            }, 400);

        });


        searchInput.addEventListener('keydown', function (event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                clearTimeout(searchTimer);

                form.submit();

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | DEPARTMENT FILTER
    |--------------------------------------------------------------------------
    |
    | Changing the department does NOT submit.
    | User must click Apply.
    |
    */

    if (departmentFilter) {

        departmentFilter.addEventListener(
            'change',
            function () {

                // Do nothing.

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS FILTER
    |--------------------------------------------------------------------------
    |
    | Changing the status does NOT submit.
    | User must click Apply.
    |
    */

    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            function () {

                // Do nothing.

            }
        );

    }

});