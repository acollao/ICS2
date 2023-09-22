<!DOCTYPE html>
<html>
    <head>
        <!-- Include CSS and JavaScript libraries like jQuery here -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous"
        />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
            crossorigin="anonymous"
        ></script>
    </head>
    <body>
        <div class="container">
            <div id="items">
                <!-- Display paginated data here -->
            </div>
        </div>

        <script>
            $(document).ready(function () {
                function fetchItems(page) {
                    $.ajax({
                        url: "/items/fetch?page=" + page,
                        type: "GET",
                        success: function (data) {
                            $("#items").html(data);
                        },
                    });
                }

                fetchItems(1); // Initial fetch

                $(document).on("click", ".pagination a", function (event) {
                    event.preventDefault();
                    var page = $(this).attr("href").split("page=")[1];
                    fetchItems(page);
                });
            });
        </script>
    </body>
</html>
