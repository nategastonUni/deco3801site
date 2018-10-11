<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="chartist/chartist.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/Chart.min.js"></script>

    <title>Operapedia Statistics Page</title>
</head>

<body>
    <?php
        require_once "uq/auth.php";
        auth_require();?>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">Operapedia - Website Statistics</a>
        <span class="navbar-text">
            <a href="index.html">Back to Site</a>
        </span>
    </nav>



    <div class="container">
        <div class="header text-center py-3">
            <h2>Response Counts</h2>
        </div>

        <div class="card-deck mb-3 text-center">
            <div class="card">
                <div class="card-header">Total Responses</div>
                <h1 id="total-responses"></h1>

            </div>
            <div class="card">
                <div class="card-header">Last 24 Hours</div>
                <h1 id="day-responses"></h1>
            </div>
            <div class="card">
                <div class="card-header">Last Week</div>
                <h1 id="week-responses"></h1>
            </div>
        </div>

        <div class="header text-center py-3">
            <h2>Demographic Pie Charts</h2>
        </div>

        <div class="card-deck mb-3 text-center">
            <div class="card">
                <div class="card-header">Students</div>
                <div class="card-body">
                    <canvas id="student-pie">
                    </canvas>
                </div>

            </div>
            <div class="card">
                <div class="card-header">Singers</div>
                <div class="card-body">
                    <canvas id="singer-pie">
                    </canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Age</div>
                <div class="card-body">
                    <canvas id="age-pie">
                    </canvas>
                </div>
            </div>
        </div>

        <div class="header text-center py-3">
            <h2>Responses Over Time</h2>
        </div>

        <div class="card-deck mb-2 text-center">
            <div class="card">
                <div class="card-header">Responses over 24 Hours</div>
                <div class="card-body">
                    <canvas id="hour-bar">
                    </canvas>
                </div>

            </div>
            <div class="card">
                <div class="card-header">Responses over 7 Days</div>
                <div class="card-body">
                    <canvas id="week-bar">
                    </canvas>
                </div>
            </div>
        </div>

        <div class="card-deck mb-1 text-center">
            <div class="card">
                <div class="card-header">Responses over 30 Days</div>
                <div class="card-body">
                    <canvas id="month-bar">
                    </canvas>
                </div>

            </div>
        </div>
    </div>

    <script>
        var result;
        $.ajax({
            method: "GET", url: "php/fetch_data.php", async: false
        }).done(function (data) {
            result = $.parseJSON(data);
            console.log(result);
        });
        console.log(result);

        var count = result.length;

        document.getElementById("total-responses").textContent = count

        //pie chart options
        var options = {
            labelInterpolationFnc: function (value) {
                return value[0]
            }
        };

        var responsiveOptions = [
            ['screen and (min-width: 640px)', {
                chartPadding: 30,
                labelOffset: 100,
                labelDirection: 'explode',
                labelInterpolationFnc: function (value) {
                    return value;
                }
            }],
            ['screen and (min-width: 1024px)', {
                labelOffset: 80,
                chartPadding: 20
            }]
        ];

        //student pie chart
        var studentCount = 0;
        for (var response in result) {
            if (result[response]["student"] == "yes") {
                studentCount++;
            }
        }
        var nonStudentCount = count - studentCount;


        var data = [{
            values: [studentCount, nonStudentCount],
            labels: ['Student, Non-Student'],
            type: 'pie',
            showlegend: false,

        }];

        var ctx = document.getElementById("student-pie");

        var studentPie = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Student", "Non-Student"],
                datasets: [{
                    data: [studentCount, nonStudentCount], backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                    ],

                }],

            },

        });

        //singer pie chart
        var singerCount = 0;
        for (var response in result) {
            if (result[response]["singer"] == "yes") {
                singerCount++;
            }
        }
        var nonSingerCount = count - singerCount;
        var singerSeries = [singerCount, nonSingerCount]
        console.log(singerSeries);

        var ctx = document.getElementById("singer-pie");

        var singerPie = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Singer", "Non-Singer"],
                datasets: [{
                    data: [singerCount, nonSingerCount], backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                }],

            },

        });


        //age pie chart
        ageSeries = [0, 0, 0, 0, 0, 0];

        for (var response in result) {
            if (result[response]["age_group"] == "15-25") {
                ageSeries[0]++;
            } else if (result[response]["age_group"] == "26-35") {
                ageSeries[1]++;
            } else if (result[response]["age_group"] == "36-45") {
                ageSeries[2]++;
            } else if (result[response]["age_group"] == "46-55") {
                ageSeries[3]++;
            } else if (result[response]["age_group"] == "56-65") {
                ageSeries[4]++;
            } else if (result[response]["age_group"] == "65+") {
                ageSeries[5]++;
            }
        }
        var ctx = document.getElementById("age-pie");

        var agePie = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["15-25", "26-35", "36-45", "46-55", "56-65", "65+"],
                datasets: [{
                    data: ageSeries, backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ],
                }],

            },

        });

        //Create date objects
        for (var response in result) {
            var dateObject = Date.parse(result[response]["submission_time"])
            result[response]["submission_time"] = dateObject;
        }

        //clicks per hour in the last 24 hours
        var currentDate = new Date();
        var millisecondsInHour = 3600000;
        var hourlyClicks = new Array(24).fill(0);
        for (var response in result) {
            var diff = currentDate - result[response]["submission_time"];
            var hourDiff = parseInt(diff / millisecondsInHour);
            if (hourDiff < 25) {
                hourlyClicks[hourDiff]++;
            }
        }
        console.log(hourlyClicks);
        hourlyClicks.reverse();
        var hourlyData = {
            labels: ['24', '23', '22', '21', '20', '19', '18', '17', '16', '15', '14', '13',
                '12', '11', '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'],
            series: [hourlyClicks]

        };

        var ctx = document.getElementById("hour-bar");

        var hourBar = new Chart(ctx, {
            type: 'line',
            options: {
                legend: { display: false }, scales: {
                    yAxes: [{ scaleLabel: { display: true, labelString: "Responses" } }],
                    xAxes: [{ scaleLabel: { display: true, labelString: "Hours Ago" } }]
                }
            },
            data: {
                labels: ['24', '23', '22', '21', '20', '19', '18', '17', '16', '15', '14', '13',
                    '12', '11', '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'],
                datasets: [{
                    data: hourlyClicks,
                    backgroundColor:
                        'rgb(255, 99, 132)'
                    ,
                }],

            },

        });

        //clicks per day in the last week
        var currentDate = new Date();
        var millisecondsInDay = 3600000 * 24;
        var dailyClicks = new Array(7).fill(0);
        for (var response in result) {
            var diff = currentDate - result[response]["submission_time"];
            var dayDiff = parseInt(diff / millisecondsInDay);
            if (dayDiff < 8) {
                dailyClicks[dayDiff]++;
            }
        }
        console.log(dailyClicks);
        dailyClicks.reverse();
        var dailyData = {
            labels: ['7', '6', '5', '4', '3', '2', '1'],
            series: [dailyClicks]

        };
        var ctx = document.getElementById("week-bar");

        function getSum(total, num) {
            return total + num;
        }

        document.getElementById("day-responses").textContent = dailyClicks[6]
        document.getElementById("week-responses").textContent = dailyClicks.reduce(getSum)

        var weekBar = new Chart(ctx, {
            type: 'bar',
            options: {
                legend: { display: false }, scales: {
                    yAxes: [{ scaleLabel: { display: true, labelString: "Responses" } }],
                    xAxes: [{ scaleLabel: { display: true, labelString: "Days Ago" } }]
                }
            },
            data: {
                labels: ['7', '6', '5', '4', '3', '2', '1'],
                datasets: [{
                    data: dailyClicks,
                    backgroundColor:
                        'rgb(255, 99, 132)'
                    ,
                }],

            },

        });

        //clicks per day in the last month
        var currentDate = new Date();
        var millisecondsInDay = 3600000 * 24;
        var monthlyClicks = new Array(30).fill(0);
        for (var response in result) {
            var diff = currentDate - result[response]["submission_time"];
            var dayDiff = parseInt(diff / millisecondsInDay);
            if (dayDiff < 30) {
                monthlyClicks[dayDiff]++;
            }
        }

        var labels = []

        for (var i = 1; i < 31; i++) {
            labels[i] = i.toString();
        }

        labels.reverse();

        monthlyClicks.reverse();

        var ctx = document.getElementById("month-bar");

        function getSum(total, num) {
            return total + num;
        }

        var monthBar = new Chart(ctx, {
            type: 'bar',
            options: {
                legend: { display: false },
                scales: {
                    yAxes: [{ scaleLabel: { display: true, labelString: "Responses" } }],
                    xAxes: [{ scaleLabel: { display: true, labelString: "Days Ago" } }]
                }
            },
            data: {
                labels: labels,
                datasets: [{
                    data: monthlyClicks,
                    backgroundColor:
                        'rgb(255, 99, 132)'
                    ,
                }],

            },

        });


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    </div>


</body>

<footer>
</footer>

</html>