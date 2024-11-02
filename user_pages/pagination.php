<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tables = document.querySelectorAll('table');
        

        tables.forEach((table) => {
            new DataTable(table, {
                columnDefs: [{
                    defaultContent: "-", // Fill missing cells with "-"
                    targets: "_all" // Apply to all columns
                }],
                autoWidth: false
            });
        });
    });
</script>