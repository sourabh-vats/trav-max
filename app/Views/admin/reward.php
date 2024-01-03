<div class="page-heading">
    <h2>Reward</h2>
</div>
<style>
    html,
    body,
    .intro {
        height: 100%;
    }

    table td,
    table th {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    thead th {
        color: #fff;
        text-align: left;
    }

    .card {
        border-radius: .5rem;
    }

    .table-scroll {
        border-radius: .5rem;
    }

    .table-scroll table thead th {
        font-size: 1.25rem;
    }

    thead {
        top: 0;
        position: sticky;
    }
</style>

<div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
    <table class="table table-striped mb-0">
        <thead style="background-color: #002d72;">
            <tr>
                <th scope="col">Sr. No.</th>
                <th scope="col">Partner Name</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($rewards as $reward) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $reward['name']; ?></td>
                    <td>Rs <?= $reward['amount']; ?></td>
                    <td><?= $reward['transaction_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>