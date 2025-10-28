<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <script>
            function updateGoldPrice(){
                var userData = {
                    gold : "YES",
                };
                fetch('upload_price.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData),
                }) 
            }
            // run immediately on load
            updateGoldPrice();
            // repeat every 30s
            setInterval(updateGoldPrice, 5000);


            function updateDollarPrice(){
                var userData = {
                    dollar : "YES",
                };
                fetch('upload_price.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData),
                }) 
            }
            // First fetch immediately
            updateDollarPrice();
            // Repeat every hour (3600000 ms)
            setInterval(updateDollarPrice, 5000);
        </script>
    </body>

</html>