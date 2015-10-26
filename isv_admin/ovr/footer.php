            <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right">Gentelella Alela! a Bootstrap 3 template by <a>Kimlabs</a>. |
                            <span class="lead"> <i class="fa fa-paw"></i> Gentelella Alela!</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <script src="<?php echo ISVIPI_ADMIN_URL .'style/js/jquery.min.js' ?>"></script>
	<script src="<?php echo ISVIPI_ADMIN_URL .'style/js/bootstrap.min.js' ?>"></script>

    <script src="<?php echo ISVIPI_ADMIN_URL .'style/js/chartjs/chart.min.js' ?>"></script>
    <script src="<?php echo ISVIPI_ADMIN_URL .'style/js/custom.js' ?>"></script>
    <script>
        var doughnutData = [
            {
                value: 30,
                color: "#455C73"
            },
            {
                value: 30,
                color: "#9B59B6"
            },
            {
                value: 60,
                color: "#BDC3C7"
            },
            {
                value: 100,
                color: "#26B99A"
            },
            {
                value: 120,
                color: "#3498DB"
            }
    ];
        var myDoughnut = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(doughnutData);
    </script>
    
</body>

</html>