/**
 * Created by MagnusPoppe on 23/01/2017.
 */


angular
    .module('prosjektWeb')
    .filter('formatDate', function ($sce)
    {
        return function(x) {
            var date = x.split(" ");
            date = date[0].split("-")
            return $sce.trustAsHtml("<span class='day'>"+date[2]+"</span><br>" +
                "<span class='month'>"+monthShort(parseInt(date[1])-1)+"</span>");
        }
    });

function monthShort( x )
{
    console.log(x)
    var month = ["JAN", "FEB", "MAR", "APR", "MAI", "JUN",
        "JUL", "AUG", "SEP", "OKT", "NOV", "DES"];

    return month[x];
}

function today()
{
    var date = new Date();
    return date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
}