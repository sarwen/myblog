var MyHiChartsConfig = {
    "cast": function(el, d) {
        el.highcharts({
            chart: {
                type: "column"
            },
            title: {
                text: "用户投资转化率"
            },
            xAxis: {
                categories: [
                    "用户 : " + d.users + "首投 : " + d.firstCast + " 复投 : " + d.reCast,
                ]
            },
            yAxis: [{
                min: 0,
                title: {
                    text: "百分比 %"
                }
            }, {
                title: {
                    text: ""
                },
                opposite: true
            }],
            legend: {
                shadow: false
            },
            tooltip: {
                shared: true,
                valueSuffix: " %"
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: [{
                name: "用户",
                color: "rgba(190,190,190,1)",
                data: [d.userPercent - 0],
                pointPadding: 0.39,
                pointPlacement: 0
            }, {
                name: "首投",
                color: "rgba(178,34,34,0.9)",
                data: [d.firstCastPercent - 0],
                pointPadding: 0.4,
                pointPlacement: 0
            }, {
                name: "复投",
                color: "rgba(28,134,238,0.8)",
                data: [d.reCastPercent - 0],
                pointPadding: 0.41,
                pointPlacement: 0
            }]
        });
    },

    "dayCast": function(el, d) {
        var xAxisData = [];
        var yAxisData = [];
        $.each(d, function(i) {
            xAxisData[i] = d[i]["reg_time"];
            yAxisData[i] = d[i]["percent"] - 0;
        });
        el.highcharts({
            title: {
                text: '日投资转化率'
            },
            xAxis: {
                categories: xAxisData
            },
            yAxis: {
                title: {
                    text: '百分比 %'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: '转化率 ',
                data: yAxisData
            }]
        });
    },

    "castStay": function(el, d) {
        if (d.length == 0) {
            alert('没有符合条件的数据');
            return false;
        }
        var arrData = [];
        $.each(d, function(i) {
            var tmpArr = [];
            if (d[i].days == -1) {
                tmpArr[0] = "未投资";
            } else {
                tmpArr[0] = d[i].days + " 天 ";
            }
            tmpArr[1] = d[i].percent - 0;
            arrData[i] = tmpArr;
        });
        el.highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '用户资金存留时间比例'
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.3f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.3f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '资金留存时间占比',
                data: arrData
            }]
        });
    }
};
