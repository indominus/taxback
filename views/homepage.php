<div class="table-responsive my-3">
    <table class="table table-border table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Author name</th>
            <th>Book name</th>
        </tr>
        </thead>
        <tbody id="results">

        </tbody>
    </table>
</div>

<style>
    .hidden {
        opacity: 0;
    }
    .animated {
        transition: all 0.5s ease-in;
    }
    .animated td {
        position: relative;
    }
    .animated {
        span {
            display: table-cell;
            position: absolute;
            left: 0;
        }
    }

    .animated.hidden{
        span {
            display: table-cell;
            position: absolute;
            right: 0;
        }
    }
</style>

<script>
    let timeout = 0;

    const wait = 500;
    const results = JSON.parse('<?php echo json_encode($results ?? []); ?>');

    if (results.length) {

        const context = document.getElementById('results');

        results.forEach((item, index) => {

            const searchRow = document.createElement('tr');
            searchRow.className = 'animated hidden';

            const indexColumn = document.createElement('td');
            indexColumn.innerHTML = index + 1;
            searchRow.appendChild(indexColumn);

            const authorColumn = document.createElement('td');
            authorColumn.innerHTML = '<span>' + item.author_name + '</span>';
            searchRow.appendChild(authorColumn);

            const bookName = document.createElement('td');
            bookName.innerHTML = '<span>' + item.book_name + '</span>';
            searchRow.appendChild(bookName);

            timeout += wait;

            setTimeout(() => {
                searchRow.className = 'animated';
            }, timeout)

            context.appendChild(searchRow);
        });

    }

    const animationRow = function () {

    }
</script>
