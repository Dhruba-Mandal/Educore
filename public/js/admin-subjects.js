document.addEventListener('DOMContentLoaded', function () {

    const box = document.getElementById('departmentMultiselect');

    if (!box) {
        return;
    }

    const trigger = document.getElementById('departmentSelectTrigger');
    const selectedItems = document.getElementById('departmentSelectedItems');
    const search = document.getElementById('departmentSearch');
    const options = box.querySelectorAll('.department-option');

    if (!trigger || !selectedItems) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SELECTED DEPARTMENTS
    |--------------------------------------------------------------------------
    */

    function updateSelectedDepartments() {

        selectedItems.innerHTML = '';

        const checkedDepartments = box.querySelectorAll(
            'input[name="department_ids[]"]:checked'
        );


        /*
        |--------------------------------------------------------------------------
        | Nothing selected
        |--------------------------------------------------------------------------
        */

        if (checkedDepartments.length === 0) {

            const placeholder = document.createElement('span');

            placeholder.className = 'department-placeholder';
            placeholder.textContent = 'Select Departments';

            selectedItems.appendChild(placeholder);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Create selected department tags
        |--------------------------------------------------------------------------
        */

        const selectedIds = new Set();

        checkedDepartments.forEach(function (checkbox) {

            const departmentId = checkbox.value;

            // Prevent duplicate department IDs
            if (selectedIds.has(departmentId)) {
                return;
            }

            selectedIds.add(departmentId);


            /*
            |--------------------------------------------------------------------------
            | Get department name directly from data-name
            |--------------------------------------------------------------------------
            */

            const departmentName =
                checkbox.dataset.name ||
                'Department';


            /*
            |--------------------------------------------------------------------------
            | Create tag
            |--------------------------------------------------------------------------
            */

            const tag = document.createElement('span');

            tag.className = 'department-selected-chip';
            tag.dataset.id = departmentId;


            /*
            |--------------------------------------------------------------------------
            | Department name
            |--------------------------------------------------------------------------
            */

            const name = document.createElement('span');

            name.className = 'department-chip-name';
            name.textContent = departmentName;


            /*
            |--------------------------------------------------------------------------
            | Remove button
            |--------------------------------------------------------------------------
            */

            const removeButton = document.createElement('button');

            removeButton.type = 'button';
            removeButton.className = 'department-chip-remove';

            removeButton.setAttribute(
                'aria-label',
                'Remove ' + departmentName
            );

            removeButton.innerHTML =
                '<i class="fa-solid fa-xmark"></i>';


            /*
            |--------------------------------------------------------------------------
            | Remove selected department
            |--------------------------------------------------------------------------
            */

            removeButton.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                checkbox.checked = false;

                updateSelectedDepartments();

            });


            tag.appendChild(name);
            tag.appendChild(removeButton);

            selectedItems.appendChild(tag);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | OPEN / CLOSE DROPDOWN
    |--------------------------------------------------------------------------
    */

    trigger.addEventListener('click', function (event) {

        event.preventDefault();
        event.stopPropagation();

        box.classList.toggle('open');

        if (
            box.classList.contains('open') &&
            search
        ) {
            setTimeout(function () {
                search.focus();
            }, 50);
        }

    });


    /*
    |--------------------------------------------------------------------------
    | DEPARTMENT CHECKBOXES
    |--------------------------------------------------------------------------
    */

    options.forEach(function (option) {

        const checkbox = option.querySelector(
            'input[name="department_ids[]"]'
        );

        if (!checkbox) {
            return;
        }

        checkbox.addEventListener('change', function () {

            updateSelectedDepartments();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | SEARCH DEPARTMENTS
    |--------------------------------------------------------------------------
    */

    if (search) {

        search.addEventListener('input', function () {

            const searchValue = this.value
                .toLowerCase()
                .trim();


            options.forEach(function (option) {

                const checkbox = option.querySelector(
                    'input[name="department_ids[]"]'
                );

                if (!checkbox) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Use database value passed through Blade
                |--------------------------------------------------------------------------
                */

                const departmentName = (
                    checkbox.dataset.name || ''
                ).toLowerCase();


                if (departmentName.includes(searchValue)) {

                    option.style.display = 'flex';

                } else {

                    option.style.display = 'none';

                }

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE DROPDOWN WHEN CLICKING OUTSIDE
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (!box.contains(event.target)) {

            box.classList.remove('open');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            box.classList.remove('open');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */

    updateSelectedDepartments();

});