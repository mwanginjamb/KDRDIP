var xmlHttp4
var xmlHttp3
var Op;

function submittheform(form)
{
    console.log($(form).submit());
}

function submitForm(url, destination, formName, btn)
{
    console.log(formName);
    // Disable Button
    var bt = document.getElementById(btn);
    if (bt) {
        bt.setAttribute('onclick','');
    }

    var form = document.getElementById(formName);
    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', url, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            // rest = xhr.responseText;
            document.getElementById(destination).innerHTML = xhr.responseText
            // alert(rest);
            // loadtab(url,destination,element,'Saved Successfully');
        } else
        {
            document.getElementById('msg').innerHTML = 'Failed to save Record';
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function loadListPage(url,destination,loader)
{
    xmlhttp=GetXmlHttpObject()
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    try
    {
        xmlhttp.open("GET",url,false);
        xmlhttp.send();
        rest = xmlhttp.responseText;
        document.getElementById(destination).innerHTML= rest;
        $(function(){
            $('table').DataTable();
        });
    }
    catch(err)
    {
        //document.getElementById("demo").innerHTML = err.message;
        rest = "System Error";
    }
    return rest;
}

async function deleteItem(url,destination,loader)
{
    if(confirm("Are you sure you wanna delete this file? ")) {
      const result = await fetch(url, {
            method: 'POST'
        });

      console.log(result.ok);
      if(result.ok) {
          const currentPage = window.location.href;
          window.location.href = currentPage;
          //location.reload();
      }
    }

    return 1;
    msg = "Are you sure you wish to delete this record ?";
    var a = confirm(msg);
    if (!a)
    {
        return false;
    }



    var xhttp = new XMLHttpRequest();
    var currentPage = document.getElementById(dest).innerHTML;
    xhttp.open("POST", url, true);
    // xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            var response = this.responseText;

            if (this.status==405) {
                console.log('Do Nothing');
                document.getElementById(destination).innerHTML=currentPage;
            } else {
                document.getElementById(destination).innerHTML=this.responseText;
            }
        }
    };
    var data = [];
   xhttp.send(JSON.stringify(data));

    //loadpage(url,destination,loader);
}

function submitItem(url,destination,loader)
{
    msg = "Are you sure you want to send this item for approval";
    var a = confirm(msg);
    if (!a)
    {
        return false;
    }

    var xhttp = new XMLHttpRequest();
    var currentPage = document.getElementById(dest).innerHTML;
    xhttp.open("POST", url, true);
    // xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            var response = this.responseText;

            if (this.status==405) {
                console.log('Do Nothing');
                document.getElementById(destination).innerHTML=currentPage;
            } else {
                document.getElementById(destination).innerHTML=this.responseText;
            }
        }
    };
    var data = [];
    xhttp.send(JSON.stringify(data));

    // loadpage(url,destination,loader);
}



function loadcomplaints(url,destination,loader,op,ID)
{
    xmlhttp=GetXmlHttpObject()
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    try
    {
        xmlhttp.open("GET",url,false);
        xmlhttp.send();
        rest = xmlhttp.responseText;
        document.getElementById(destination).innerHTML= rest;
        $(function(){
            //var table = $('#dataTables-1').DataTable();
            $('#dataTables-1').dataTable( {
                "bProcessing": true,
                "sAjaxSource": op+"_data.php?i=1&ID="+ID+"&Option="+op,

            } );
            $('#dataTables-1 tbody').on( 'click', 'tr', function () {
                //alert('Selected');
                var data = $('#dataTables-1').DataTable().row(this).data();
                var ComplaintID = data[2];
                var Draft = data[5];

                ComplaintID = ComplaintID.replace(/['"]+/g, '');
                if (Draft =='Draft')
                {
                    document.getElementById(destination).innerHTML = fetch_page('register.php?edit=1&ID='+ID+'&ComplaintID='+ComplaintID);
                } else
                {
                    document.getElementById(destination).innerHTML = fetch_page('complaints.php?edit=1&ID='+ID+'&ComplaintID='+ComplaintID);
                }
                //console.log(data);
                //console.log(data[2]);
            } );
        });
    }
    catch(err)
    {
        //document.getElementById("demo").innerHTML = err.message;
        rest = "System Error";
    }
    return rest;
}

function uploadfile(url,destination,id, baseUrl)
{
    var form = document.getElementById('upload-form');
    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', url, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            if (rest=='0')
            {
                var url2 = baseUrl+'/suppliers/pricelist?id='+id;
                loadtab(url2,destination,1);
            } else
            {
                document.getElementById('msg').innerHTML = 'Something happened and we were not able to complete your request';
            }
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function saverecords(url,destination,id, baseUrl, element)
{
    var form = document.getElementById('supplier-form');
    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', url, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            loadtab(url,destination,element,'Saved Successfully');
        } else
        {
            document.getElementById('msg').innerHTML = 'Failed to save Record';
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function submitmyform()
{
    var form = document.getElementById('rightsform');
    var UserGroupID = document.getElementById('UserGroupID').value;
    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', 'usergrouprights_save.php', true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            if (rest=='0')
            {
                loadmypage('usergrouprights_list.php?saved=1&UserGroupID='+UserGroupID,'cell-content','loader','usergrouprights',UserGroupID,'3');
                document.getElementById('msg').innerHTML = 'Records Sucessfully Saved';
            } else
            {
                document.getElementById('msg').innerHTML = 'Something happened and we were not able to complete your request';
            }
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function uploadsignature(form,baseUrl)
{
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', baseUrl+'/users/uploadsignature', true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            //alert('qqq');
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            if (rest=='0')
            {
                alert('Something went wrong and we cound not upload the file');
                //loadmypage('usergrouprights_list.php?saved=1&UserGroupID='+UserGroupID,'cell-content','loader','usergrouprights',UserGroupID,'3');
                //document.getElementById('msg').innerHTML = 'Records Sucessfully Saved';
            } else
            {
                //alert('qqq');
                document.getElementById('Signature').src = rest;
            }
        } else
        {
            alert('Something went wrong and we cound not upload the file');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function updatepage(url, redirecturl, formname)
{
    var form = document.getElementById(formname);
    if (document.getElementById('editorText'))
    {
        //alert(editor.getData());
        if (!document.getElementById('TemplateText'))
        {
            var TemplateText = document.createElement("input");
        }
        // Add the new element to our form.
        form.appendChild(TemplateText);
        TemplateText.name = "TemplateText";
        TemplateText.type = "hidden";
        TemplateText.value = editor.getData();
    }

    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            var obj =  JSON.parse(xhr.responseText);
            var Result 		= obj.jData[0].Result;
            if (Result == 0)
            {
                if (redirecturl!='')
                {
                    location.href = redirecturl;
                } else
                {
                    var Message = obj.jData[0].Message;
                    document.getElementById('msg').innerHTML = Message;
                }
                return;
            } else
            {
                var Message = obj.jData[0].Message;
                document.getElementById('msg').innerHTML = Message;
                return;
            }
        } else
        {
            document.getElementById('msg').innerHTML = 'Failed to Save record';
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function addtoform(url,destination, remove)
{
    if (remove == 1)
    {
        msg = "Are you sure you wish to delete this record(s).";
        var a = confirm(msg);
        if (!a)
        {
            return false;
        }
    }

    var form = document.getElementById('data_form');
    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', url , true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            rest = xhr.responseText;

            document.getElementById(destination).innerHTML = rest;
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function submitfile1(baseUrl)
{
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('myfile');
    var uploadButton = document.getElementById('upload-button');
    var SessionID = document.getElementById('SessionID').value;
    var SessionID2 = document.getElementById('SessionID2').value;
    var DocumentName = document.getElementById('DocumentName').value;

    // Create a new FormData object.
    var formData = new FormData(form);
    //formData.append('myfile', fileSelect.files, fileSelect.name);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', baseUrl+'/complaints/upload_docs?remove=0&SessionID='+SessionID+'&DocumentID=0', true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            DocumentName.value = '';
            //fileSelect.value ='';
            uploadButton.innerHTML = 'Upload';
            document.getElementById('register_docs').innerHTML = fetch_page(baseUrl+'/complaints/register_docs?remove=0&SessionID='+SessionID+'&DocumentID=0');
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function uploadfile1(baseUrl,RDID, ReportScore)
{
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('myfile');
    var Quarter = document.getElementById('Quarter').value;
    var Year = document.getElementById('Year').value;
    var InstitutionID = document.getElementById('InstitutionID').value;
    var ReportID = document.getElementById('ReportID').value;

    var R = document.createElement("input");
    form.appendChild(R);
    R.name = "RequiredDocumentID";
    R.type = "hidden";
    R.value = RDID;
    var S = document.createElement("input");
    form.appendChild(S);
    S.name = "Score";
    S.type = "hidden";
    S.value = ReportScore;

    // Create a new FormData object.
    var formData = new FormData(form);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', baseUrl+'/reports/uploaddocument', true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            document.getElementById('documents').innerHTML = fetch_page(baseUrl+'/reports/documents?ReportID='+ReportID+'&Quarter='+Quarter+'&Year='+Year+'&InstitutionID='+InstitutionID);
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function fileTransfer(baseUrl,url)
{
    var result = fetch_page(baseUrl+url);
    var obj =  JSON.parse(result);
    var error = obj.jData[0].error;
    var ID = obj.jData[0].ID;
    var ComplaintID = obj.jData[0].ComplaintID;
    var msg = obj.jData[0].msg;

    if (error==0)
    {
        location.href = baseUrl+'/complaints?ID='+ID;
    } else
    {
        document.getElementById('ComplaintTransfer').innerHTML = fetch_page(baseUrl+'/complaints/complaint_transfer?ID='+ID+'&ComplaintID='+ComplaintID+'&msg='+msg);
    }
}

function submitfile2(baseUrl)
{
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('myfile');
    var uploadButton = document.getElementById('upload-button');
    var SessionID = document.getElementById('SessionID').value;
    var DocumentName = document.getElementById('DocumentName').value;

    // Create a new FormData object.
    var formData = new FormData(form);
    //formData.append('myfile', fileSelect.files, fileSelect.name);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', baseUrl+'/complaints/upload_docs2?SessionID='+SessionID, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            DocumentName.value = '';
            fileSelect.value ='';
            uploadButton.innerHTML = 'Upload';
            document.getElementById('register_docs').innerHTML = fetch_page(baseUrl+'register_docs.php?remove=0&SessionID='+SessionID+'&DocumentID=0');
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function submitfile3(baseUrl)
{
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('myfile');
    var uploadButton = document.getElementById('upload-button');
    var ComplaintID = document.getElementById('ComplaintID').value;
    var ComplaintStatusID = document.getElementById('ComplaintStatusID').value;

    var DocumentName = document.getElementById('DocumentName').value;
    if (DocumentName=='')  { document.getElementById('docmsg').innerHTML = 'Missing Document Description'; return;}

    // Create a new FormData object.
    var formData = new FormData(form);
    //formData.append('myfile', fileSelect.files, fileSelect.name);

    // Set up the request.
    var xhr = new XMLHttpRequest();
    // Open the connection.
    xhr.open('POST', baseUrl+'/complaints/upload_docs2?ComplaintID='+ComplaintID, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            // File(s) uploaded.
            rest = xhr.responseText;
            //alert(rest);
            DocumentName.value = '';
            fileSelect.value ='';
            uploadButton.innerHTML = 'Upload';
            document.getElementById('attachments').innerHTML = fetch_page(baseUrl+'/complaints/complaint_attachments?ComplaintID='+ComplaintID+'&ComplaintStatusID='+ComplaintStatusID);
        } else
        {
            alert('An error occurred!');
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function formupdate(form)
{
    if (document.getElementById('editorText'))
    {
        //alert(editor.getData());
        if (!document.getElementById('TemplateText'))
        {
            var TemplateText = document.createElement("input");
        }
        // Add the new element to our form.
        form.appendChild(TemplateText);
        TemplateText.name = "TemplateText";
        TemplateText.type = "hidden";
        TemplateText.value = editor.getData();
    }

    // Finally submit the form.
    form.submit();
}

function updatepage(url, redirecturl, formname)
{
    var form = document.getElementById(formname);
    if (document.getElementById('editorText'))
    {
        //alert(editor.getData());
        if (!document.getElementById('TemplateText'))
        {
            var TemplateText = document.createElement("input");
        }
        // Add the new element to our form.
        form.appendChild(TemplateText);
        TemplateText.name = "TemplateText";
        TemplateText.type = "hidden";
        TemplateText.value = editor.getData();
    }

    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            var obj =  JSON.parse(xhr.responseText);
            var Result 		= obj.jData[0].Result;
            if (Result == 0)
            {
                if (redirecturl!='')
                {
                    location.href = redirecturl;
                } else
                {
                    var Message = obj.jData[0].Message;
                    document.getElementById('msg').innerHTML = Message;
                }
                return;
            } else
            {
                var Message = obj.jData[0].Message;
                document.getElementById('msg').innerHTML = Message;
                return;
            }
        } else
        {
            document.getElementById('msg').innerHTML = 'Failed to Save record';
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function generate_all_graphs(baseUrl,id)
{
    //return;
    document.getElementById('sidepanel').innerHTML = fetch_page(baseUrl+'/complaints/sidepanel2?id='+id);
    document.getElementById('cell-content').innerHTML = fetch_page(baseUrl+'/complaints/profilehome');
    create_bargraph(baseUrl+'/complaints/graph1_data?id='+id, 'canvas1');
    create_bargraph(baseUrl+'/complaints/graph2_data?id='+id, 'canvas2');
    create_bargraph(baseUrl+'/complaints/graph3_data?id='+id, 'canvas3');
    create_bargraph(baseUrl+'/complaints/graph4_data?id='+id, 'canvas4');
    create_bargraph(baseUrl+'/complaints/graph5_data?id='+id, 'canvas5');
    create_bargraph(baseUrl+'/complaints/graph6_data?id='+id, 'canvas6');
    create_bargraph(baseUrl+'/complaints/graph7_data?id='+id, 'canvas7');
    create_bargraph(baseUrl+'/complaints/graph8_data?id='+id, 'canvas8');
    create_bargraph2(baseUrl+'/complaints/graph9_data?id='+id, 'canvas9', 'legend9');
    create_bargraph2(baseUrl+'/complaints/graph10_data?id='+id, 'canvas10', 'legend10');
    create_piechart(baseUrl+'/complaints/graph10b_data?id='+id, 'canvas10b', 'legend10b');
    create_bargraph2(baseUrl+'/complaints/graph11_data?id='+id, 'canvas11', 'legend11');
    create_piechart(baseUrl+'/complaints/graph11b_data?id='+id, 'canvas11b', 'legend11b');
    create_bargraph2(baseUrl+'/complaints/graph12_data?id='+id, 'canvas12', 'legend12');
    create_piechart(baseUrl+'/complaints/graph12b_data?id='+id, 'canvas12b', 'legend12b');
    create_piechart(baseUrl+'/complaints/graph13b_data?id='+id, 'canvas13b', 'legend13b');
}

function create_bargraph(url, destination)
{
    var mydata = fetch_data(url);
    //alert(mydata);
    var barChartData = {
        labels : mydata['label'],
        datasets : [
            {
                fillColor : "#0000FF",
                data : mydata['data']
            }
        ]

    }
    var ctx = document.getElementById(destination).getContext("2d");
    var myBarChart = new Chart(ctx).Bar(barChartData, {	responsive : true, bezierCurve : false,animation: false });
    var chartimage = myBarChart.toBase64Image();
    var jdestination = "j_"+destination;
    if (document.getElementById(jdestination))
    {
        document.getElementById(jdestination).value=chartimage;
        //document.getElementById("i_"+destination).src=chartimage;
        //alert(chartimage);
    }
}

function create_bargraph_new(url, destination)
{
    var mydata = fetch_data(url);
    //alert(mydata);
    var barChartData = {
        labels : mydata['label'],
        datasets : [
            {
                fillColor : "#0000FF",
                data : mydata['data']
            }
        ]
    }

    var ctx = document.getElementById(destination).getContext("2d");
    var myBarChart = new Chart(ctx).Bar(barChartData, {	responsive : true, bezierCurve : false,animation: false });
    var chartimage = myBarChart.toBase64Image();
    Session["destination"] = chartimage;
    document.getElementById("url").src=chartimage;
}

function create_bargraph2(url, destination, mylegend)
{
    var mydata = fetch_data(url);
    //alert(mydata);
    var barChartData = mydata;
    var ctx = document.getElementById(destination).getContext("2d");
    var myBarChart = new Chart(ctx).StackedBar(barChartData,
        { responsive : true, scaleShowLabels: true, segmentShowStroke : true, bezierCurve : false,animation: false  });
    //document.getElementById("legend9").innerHTML = myBarChart.generateLegend();
    legend(document.getElementById(mylegend), barChartData,myBarChart);
    var legendstr = document.getElementById(mylegend).innerHTML;
    var chartimage = myBarChart.toBase64Image();
    var jdestination = "j_"+destination;
    if (document.getElementById(jdestination))
    {
        document.getElementById(jdestination).value=chartimage;
        //var legendstr = legend(document.getElementById('k_'+mylegend), barChartData,myBarChart);
        //alert('k_'+mylegend);
        document.getElementById('k_'+mylegend).value=legendstr;
        //alert(legendstr);
        //document.getElementById("i_"+destination).src=chartimage;
        //alert(chartimage);
    }
}

function create_piechart(url, destination, mylegend)
{
    var mydata = fetch_data(url);
    //alert(mydata['data']);
    var pieData = mydata;
    var ctx1 = document.getElementById(destination).getContext("2d");
    var myPieChart = new Chart(ctx1).Pie(pieData, {segmentShowStroke : true, scaleShowLabels: true, bezierCurve : false,animation: false });
    legend(document.getElementById(mylegend), pieData);
    var legendstr = '';
    for (i = 0; i < mydata.length; i++)
    {
        legendstr += mydata[i]['color']+',';//document.getElementById(mylegend).innerHTML;
    }
    var chartimage = myPieChart.toBase64Image();
    var jdestination = "j_"+destination;
    if (document.getElementById(jdestination))
    {
        document.getElementById(jdestination).value=chartimage;
        document.getElementById('k_'+mylegend).value=legendstr;
        //document.getElementById("i_"+destination).src=chartimage;
        //alert(chartimage);
    }
}

function load_graph1()
{

    document.getElementById('content').innerHTML = fetch_page('profilehome.php');

    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var mydata = fetch_data('graph1_data.php');
    //alert(mydata);
    var barChartData = {
        labels : mydata['label'],
        datasets : [
            {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data : mydata['data']
            }
        ]

    }

    var ctx = document.getElementById("canvas").getContext("2d");
    var myBarChart = new Chart(ctx).Bar(barChartData, {	responsive : true });
    var obj = fetch_data('rptstatus_data.php');

    var pieData = [
        {
            value: obj.jData[0].Total,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: obj.jData[0].Status
        },
        {
            value: obj.jData[1].Total,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: obj.jData[1].Status
        },
        {
            value: obj.jData[2].Total,
            color: "#FDB45C",
            highlight: "#FFC870",
            label: obj.jData[2].Status
        },
        {
            value: obj.jData[3].Total,
            color: "#FDB45C",
            highlight: "#FFC870",
            label: obj.jData[3].Status
        }
    ]

    var ctx1 = document.getElementById("canvas1").getContext("2d");
    var myPieChart = new Chart(ctx1).Pie(pieData, {segmentShowStroke : true, legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"});
    //var myPieChart = new Chart(ctx1[0]).Pie(data,{responsive : true});

    //url = "rptcounty_data.php?i=1"
    //var objArray = fetch_data(url);
    //alert(objArray);
    //load_tabledata(objArray);
    loadTable('rptcounty',1);
    loadTable2('rptreportarea',1);
    loadTable3('rptstatus1',1);
}

function cancelform(baseUrl)
{
    var a = confirm("Are you sure you wish to cancel");
    if (a)
    {
        location.href = baseUrl+'/complaints?ID=1';
    } else
    {
        return false;
    }
}

function saveform(op,baseurl)
{
    var form = document.getElementById('file-form');
    if (op==1)
    {
        var a = confirm("Are you sure you wish to submit");
        if (!a)
        {
            //return false;
        }

        // Mandatory Fields
        var NatureofComplaintID = document.getElementById('NatureofComplaintID').value;
        var Organization = document.getElementById('Organization').value;
        var IncidentDate = document.getElementById('IncidentDate').value;
        var ComplaintSummary = document.getElementById('ComplaintSummary').value;
        var CountyID = document.getElementById('CountyID').value;
        var ConstituencyID = document.getElementById('ConstituencyID').value;
        var WardID = document.getElementById('WardID').value;
        //var Area = document.getElementById('Area').value;
        var OfficerJustification = document.getElementById('OfficerJustification').value;
        var PriorityID = document.getElementById('PriorityID').value;
        var LastName = document.getElementById('LastName').value;
        var FirstName = document.getElementById('FirstName').value;
        var AgeCategoryID = document.getElementById('AgeCategoryID').value;
        var GenderID = document.getElementById('GenderID').value;
        var CountryID = document.getElementById('CountryID').value;
        var Anonymous = document.getElementById('Anonymous').checked;
        var ReferenceID = document.getElementById('ReferenceID').value;
        var IncidentCountyID = document.getElementById('IncidentCountyID').value;
        var DoYouKnow = document.getElementById('DoYouKnow').checked;

        //var AgencyID = document.getElementByName('AgencyID').value;

        //alert(NatureofComplaintID);

        if ((NatureofComplaintID=='') || (NatureofComplaintID=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Nature of Complaints';
            document.getElementById('msg1').innerHTML = 'Missing Nature of Complaints';
            return;
        }
        if ((Organization=='') || (Organization=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Organization';
            document.getElementById('msg1').innerHTML = 'Missing Organization';
            return;
        }
        if ((IncidentDate=='') || (IncidentDate=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Incident Date';
            document.getElementById('msg1').innerHTML = 'Missing Incident Date';
            return;
        }
        if ((ComplaintSummary=='') || (ComplaintSummary=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Complaint Summary';
            document.getElementById('msg1').innerHTML = 'Missing Complaint Summary';
            return;
        }
        if ((OfficerJustification=='') || (OfficerJustification=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Receiving officer Recommendation';
            document.getElementById('msg1').innerHTML = 'Missing Receiving officer Recommendation';
            return;
        }
        if ((PriorityID=='') || (PriorityID=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing Priority';
            document.getElementById('msg1').innerHTML = 'Missing Priority';
            return;
        }
        if ((IncidentCountyID=='') || (IncidentCountyID=='0'))
        {
            document.getElementById('msg').innerHTML = 'Missing County where the incident took place';
            document.getElementById('msg1').innerHTML = 'Missing County where the incident took place';
            return;
        }

        if (DoYouKnow)
        {
            if ((ReferenceID=='') || (ReferenceID=='0'))
            {
                document.getElementById('msg').innerHTML = 'Missing How did you here about Sema Piga Repoti';
                document.getElementById('msg1').innerHTML = 'Missing How did you here about Sema Piga Repoti';
                return;
            }
        }
        if (!Anonymous)
        {
            if ((LastName=='') || (LastName=='0'))
            {
                document.getElementById('msg').innerHTML = 'Missing Last Name';
                document.getElementById('msg1').innerHTML = 'Missing Last Name';
                return;
            }
            if ((FirstName=='') || (FirstName=='0'))
            {
                document.getElementById('msg').innerHTML = 'Missing Other Names';
                document.getElementById('msg1').innerHTML = 'Missing Other Names';
                return;
            }
            if ((AgeCategoryID=='') || (AgeCategoryID=='0'))
            {
                document.getElementById('msg').innerHTML = 'Missing Age Group';
                document.getElementById('msg1').innerHTML = 'Missing Age Group';
                return;
            }
            if ((GenderID=='') || (GenderID=='0'))
            {
                document.getElementById('msg').innerHTML = 'Missing Gender';
                document.getElementById('msg1').innerHTML = 'Missing Gender';
                return;
            }

            if (CountryID==1)
            {
                if ((CountyID=='') || (CountyID=='0'))
                {
                    document.getElementById('msg').innerHTML = 'Missing County';
                    document.getElementById('msg1').innerHTML = 'Missing County';
                    return;
                }

            }
        }
    }

    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'save?op='+op, true);
    // Set up a handler for when the request finishes.
    xhr.onload = function ()
    {
        if (xhr.status === 200)
        {
            var obj =  JSON.parse(xhr.responseText);
            var Result 		= obj.jData[0].Result;

            if (Result == 0)
            {
                if ((op==0) || (op==2))
                {
                    document.getElementById('ComplaintID').value = obj.jData[0].ComplaintID;
                    document.getElementById('ProfileID').value = obj.jData[0].ProfileID;
                    if (op==0)
                    {
                        document.getElementById('savemsg').innerHTML = 'Saved to Draft';
                        document.getElementById('savemsg1').innerHTML = 'Saved to Draft';
                    } else
                    {
                        document.getElementById('savemsg').innerHTML = 'Auto Saved';
                        document.getElementById('savemsg1').innerHTML = 'Auto Saved';
                    }
                    var Message = obj.jData[0].Message;
                    document.getElementById('msg').innerHTML = Message;
                    document.getElementById('msg1').innerHTML = Message;
                    var ComplaintID = obj.jData[0].ComplaintID;
                    var stateObj = { foo: "bar" };
                    var ID = 6;
                    var url = baseurl+'/complaints/register?edit=1&ComplaintID='+ComplaintID+'&ID='+ID;
                    window.history.pushState(stateObj,"Create", url);
                    return;
                } else
                {
                    location.href = baseurl+'/complaints?ID=0';
                    return;
                }
            } else
            {
                var Message = obj.jData[0].Message;
                document.getElementById('msg').innerHTML = Message;
                document.getElementById('msg1').innerHTML = Message;
            }
        } else
        {
            document.getElementById('msg').innerHTML = 'Failed to Save record';
            document.getElementById('msg1').innerHTML = 'Failed to Save record';
        }
    };
    // Send the Data.
    xhr.send(formData);
}

function hidecounty(C)
{
    if (C==1)
    {
        document.getElementById("CountyComp").innerHTML='County <span style="color:#F00">*</span>';
        document.getElementById("pcodeid").style.display = "block";
        document.getElementById("pcode").style.display = "none";
    } else
    {
        document.getElementById("CountyComp").innerHTML ='County';
        document.getElementById("pcodeid").style.display = "none";
        document.getElementById("pcode").style.display = "block";
    }
}

function fetch_page(url)
{
    xmlhttp=GetXmlHttpObject()
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    try
    {
        xmlhttp.open("POST",url,false);
        xmlhttp.send();
        rest = xmlhttp.responseText;
    }
    catch(err)
    {
        //document.getElementById("demo").innerHTML = err.message;
        rest = "System Error";
    }
    return rest;
}

function fetch_data1(url)
{
    xmlhttp=GetXmlHttpObject()
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    try {
        xmlhttp.open("GET",url,false);
        xmlhttp.send();
        rest = xmlhttp.responseText;
    }
    catch (e) {
        //alert ("Cannot connect to the server!");
        //return;
        rest = '[{"Error":1}]';
    }
    //alert(rest);
    var obj = JSON.parse(rest);
    return obj;
}

function load_tabledata(objArray)
{
    var ErrorMessage = "No data available in table";

    /*	if (objArray.indexOf('Error') > -1)
     {
     if (objArray[0].Error == "1")
     {
     ErrorMessage = "Unable to connect to server";
     objArray = [];
     }
     }*/

    $(function()
    {
        $('#dataTables-1').dataTable(
            {
                "oLanguage":
                    {
                        "sEmptyTable": ErrorMessage
                    },
                "bProcessing": false,
                "autoWidth": false,
                "info":     false,
                "lengthMenu": 25,
                "bLengthChange": false,
                "aaData": objArray
            } );
    });

}

function getItemDetails(ItemID)
{
    url = "itemdetails.php?ItemID="+ItemID;
    //alert(url);
    var obj = fetch_data(url)

    //obj.jData[0].UnitPrice;
    //obj.jData[0].UnitofMeasure;
    //obj.jData[0].ItemName;
    document.getElementById('UnitofMeasureName').value 		= obj.jData[0].UnitofMeasure;
    document.getElementById('UnitPrice').value 		= obj.jData[0].UnitPrice;
}

function calulateItemTotal()
{
    document.getElementById('Amount').value = document.getElementById('Quantity').value * document.getElementById('UnitPrice').value
}

function fetch_data(url)
{
    xmlhttp=GetXmlHttpObject()
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    xmlhttp.open("GET",url,false);
    xmlhttp.send();
    rest = xmlhttp.responseText;
    //alert(rest);
    var obj = JSON.parse(rest);
    return obj;
}

function loadtextpage(url,destination,loader,field, showtoolbar)
{
    dest = destination;
    Loader = loader;
    Field = field;
    ShowToolbar = showtoolbar;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    if (document.getElementById(loader))
        document.getElementById(loader).innerHTML= 'loading....'
    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=textpagecontent
    xmlHttp4.open("POST",url,true)
    xmlHttp4.send(null)
}

function textpagecontent()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        if (document.getElementById(Loader))
            document.getElementById(Loader).innerHTML= ""

        document.getElementById(dest).innerHTML=xmlHttp4.responseText;
        if (ShowToolbar)
        {
            CKEDITOR.replace( Field );
        } else
        {
            CKEDITOR.replace( Field, {removePlugins: 'toolbar'} );
        }
    }
}

function swapcustomer(id)
{
    if (document.getElementById(id).checked == true)
    {
        document.getElementById('Company').style.display = 'block';
        document.getElementById('lname').style.display = 'none';
        document.getElementById('oname').style.display = 'none';
        document.getElementById('uname').style.display = 'none';
        document.getElementById('pwd').style.display = 'none';
    } else
    {
        document.getElementById('Company').style.display = 'none';
        document.getElementById('lname').style.display = 'block';
        document.getElementById('oname').style.display = 'block';
        document.getElementById('uname').style.display = 'block';
        document.getElementById('pwd').style.display = 'block';

    }
}

function loadTable(op,ID)
{
    $(function(){
        $('#dataTables-1').dataTable
        (
            {
                "sDom": 'T<"clear">lfrtip',
                "bProcessing": true,
                "sAjaxSource": op+"_data.php?i=1&ID="+ID+"&Option="+op
                /*,
                 "oTableTools": {
                 //"sSwfPath": "http://cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf" //on remote server
                 "sSwfPath": "/nipcrm/swf/copy_csv_xls_pdf.swf" //on local server
                 ,"aButtons": [
                 {
                 "sExtends": "copy",
                 "sToolTip": "Copy to clipboard"
                 },
                 "print",
                 {
                 "sExtends": "collection",
                 "sButtonText": "Save",
                 "aButtons": [
                 {
                 "sExtends": "pdf",
                 "sToolTip": "Save as PDF",
                 "sFileName": "*_pdf.pdf",
                 //"sTitle": "Project title: "+_projTitle,
                 //"sPdfMessage":"Client: "+_custName+", "+_custEmail+", "+_custOffLoc

                 },
                 {
                 "sExtends": "xls",
                 "sToolTip": "Save as EXCEL",
                 "sFileName": "*_xls.xls"
                 },
                 {
                 "sExtends": "csv",
                 "sToolTip": "Save as CSV",
                 "sFileName": "*_csv.csv"
                 }
                 ]
                 }
                 ]
                 }*/
            });

    });
}

function loadTable2(op,ID)
{

    $(function(){
        $('#dataTables-2').dataTable( {
            "bProcessing": true,
            "sAjaxSource": op+"_data.php?i=1&ID="+ID+"&Option="+op,

        } );
    });

}

function loadTable3(op,ID)
{

    $(function(){
        $('#dataTables-3').dataTable( {
            "Processing": false,
            "autoWidth": false,
            "info":     false,
            "lengthMenu": 25,
            "bLengthChange": false,
            "paging":   false,
            "filter":   false,
            "sAjaxSource": op+"_data.php?i=1&ID="+ID+"&Option="+op,

        } );
    });

}

function loadmytab(url,destination,element,op,id)
{
    Op = op;
    ID = id;
    var lis = document.getElementById('flowertabs').getElementsByTagName('a');
    for (var i = 0; i < lis.length; ++i)
    {
        lis[i].className = lis[i].className.replace(/\bselected\b/g, '');
        if (element==i)
        {
            lis[i].className = 'selected';
        }
    }

    dest = destination;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=mytabpage
    xmlHttp4.open("POST",url,true)
    xmlHttp4.send(null)
}

function mytabpage()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        document.getElementById(dest).innerHTML=xmlHttp4.responseText;
        loadTable(Op, ID);
    }
}

function loadtab(url,destination,element, message)
{
    var lis = document.getElementById('t-tabs').getElementsByTagName('li');
    for (var i = 0; i < lis.length; ++i)
    {
        lis[i].className = lis[i].className.replace(/\bactive\b/g, '');
        if (element==i)
        {
            lis[i].className = 'active';
        }
    }
    dest = destination;
    msg = message;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=tabpage
    xmlHttp4.open("POST",url,true)
    xmlHttp4.send(null)
}

function tabpage()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        document.getElementById(dest).innerHTML=xmlHttp4.responseText
        if (msg)
        {
            document.getElementById('msg').innerHTML= msg;
        }
    }
}

function loadnewpage(url,destination)
{
    dest = destination;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=tabpage
    xmlHttp4.open("POST",url,true)
    xmlHttp4.send(null)
}

function loadpage(url,destination,loader)
{
    // $('table').DataTable();
    dest = destination;
    currentPage = document.getElementById(destination).innerHTML;
    Loader = loader;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    if (document.getElementById(destination))
        document.getElementById(destination).innerHTML= 'loading....'
    //document.getElementById(loader).innerHTML= '<img src="images/ajax-loader.gif" width="16" height="16" />'
    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=contentpage
    xmlHttp4.open("GET",url,true)
    xmlHttp4.send(null)
}

function contentpage()
{
    // console.log(xmlHttp4);
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete") {

        if (document.getElementById(Loader)) {
            document.getElementById(dest).innerHTML= ""
        }
        if (xmlHttp4.status==405) {
            console.log('Do Nothing');
            document.getElementById(dest).innerHTML=currentPage;
        } else {
            document.getElementById(dest).innerHTML=xmlHttp4.responseText;
        }

        $('table').DataTable();
    }
}

function loadmypage(url,destination,loader,op,id,pageid)
{
    dest = destination;
    Loader = loader;
    Op = op;
    ID = id;
    PageID = pageid;
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    if (document.getElementById(loader))
        document.getElementById(loader).innerHTML= 'loading....'
    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=mycontentpage
    xmlHttp4.open("POST",url,true)
    xmlHttp4.send(null)
}

function mycontentpage()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        if (document.getElementById(Loader))
            document.getElementById(Loader).innerHTML= ""
        document.getElementById(dest).innerHTML=xmlHttp4.responseText;
        if (PageID==1)
            loadTable(Op,ID)
        else if (PageID==2)
            loadTable2(Op,ID)
        else if (PageID==3)
            loadTable3(Op,ID)
        else
            loadTable(Op,ID)
    }
}

function sendpage(url)
{
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    document.getElementById("loader").innerHTML= "Loading.."
    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=sendpagecontent
    xmlHttp4.open("GET",url,true)
    xmlHttp4.send(null)
}

function sendpagecontent()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        document.getElementById("loader").innerHTML= ""
        document.getElementById("Message").innerHTML=xmlHttp4.responseText
    }
}


function loadsmsoptionpage(url)
{
    xmlHttp3=GetXmlHttpObject()
    if (xmlHttp3==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    url=url+"&sid="+Math.random()
    xmlHttp3.onreadystatechange=smsoptionpage
    xmlHttp3.open("GET",url,true)
    xmlHttp3.send(null)
}

function smsoptionpage()
{
    if (xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    {
        document.getElementById("sms_number").innerHTML=xmlHttp3.responseText
    }
}

function loadnumbers(url)
{
    xmlHttp4=GetXmlHttpObject()
    if (xmlHttp4==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }

    url=url+"&sid="+Math.random()
    xmlHttp4.onreadystatechange=numberspage
    xmlHttp4.open("GET",url,true)
    xmlHttp4.send(null)
}

function numberspage()
{
    if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")
    {
        document.getElementById("numbers").innerHTML=xmlHttp4.responseText
    }
}

function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        //Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function textCounter( field,counter )
{
    var max_length = 200;
    if( field.value.length > max_length )
    {
        alert( "Too many characters: " + max_length);
        field.value= field.value.substr( 0, max_length );
        counter.value = 0;
    }  else
    {
        counter.value = max_length - field.value.length;
    }
}

function ck_array(dest)
{
    var c_value = "";
    var j = document.deleteform.checkbox_name.length;
    for (var i=0; i < j; i++)
    {
        if (document.deleteform.checkbox_name[i].checked)
        {
            c_value = c_value + "&item" + i + "=" + document.deleteform.checkbox_name[i].value;
        }
    }
    dest.value = c_value;
}

function ck_selectall(op,dest)
{
    for (var i=0; i < document.deleteform.checkbox_name.length; i++)
    {
        document.deleteform.checkbox_name[i].checked = op;
    }
    ck_array(dest);
}

function deleteConfirm(msg, url)
{
    var a = confirm(msg);

    if (a)
    {
        loadpage(url);
        return true;

    }
    else
    {
        return false;
    }
}

function deleteConfirm2(msg, url ,destination,loader,option)
{
    var a = confirm(msg);

    if (a)
    {
        loadmypage(url,destination,loader,option);
        return true;

    }
    else
    {
        return false;
    }
}

function startUpload()
{
    document.getElementById('f1_upload_process').style.visibility = 'visible';
    document.getElementById('f1_upload_form').style.visibility = 'hidden';
    return true;
}

function stopUpload(success)
{
    var result = '';
    result = '<span class="msg"> ' + success + ' <\/span><br/><br/>';
    document.getElementById('f1_upload_process').style.visibility = 'hidden';
    document.getElementById('f1_upload_form').innerHTML = result;

    document.getElementById('f1_upload_form').style.visibility = 'visible';

    return true;
}


function rights_array(dest)
{
    var c_value = "";

    var j = document.deleteform.checkbox_name.length;
    for (var i=0; i < j; i++)
    {
        if (document.deleteform.checkbox_name[i].checked)
        {
            c_value = c_value + "&view" + i + "=" + document.deleteform.checkbox_name[i].value;
        }
    }
    var j = document.deleteform.checkbox_name1.length;
    for (var i=0; i < j; i++)
    {
        if (document.deleteform.checkbox_name1[i].checked)
        {
            c_value = c_value + "&edit" + i + "=" + document.deleteform.checkbox_name1[i].value;
        }
    }
    var j = document.deleteform.checkbox_name2.length;
    for (var i=0; i < j; i++)
    {
        if (document.deleteform.checkbox_name2[i].checked)
        {
            c_value = c_value + "&delete" + i + "=" + document.deleteform.checkbox_name2[i].value;
        }
    }

    dest.value = c_value;
}

function rights_selectall(op,dest)
{
    for (var i=0; i < document.deleteform.checkbox_name.length; i++)
    {
        document.deleteform.checkbox_name[i].checked = op;
        document.deleteform.checkbox_name1[i].checked = op;
        document.deleteform.checkbox_name2[i].checked = op;
    }
    rights_array(dest);
}

function addtext(newtext,dest)
{
    /*document.myform.outputtext.value += newtext;*/
    dest.value += newtext;
}

function anonymously()
{
    if (document.getElementById('Anonymous').checked )
    {
        document.getElementById('contactinfo').style.display = 'none';
    } else
    {
        document.getElementById('contactinfo').style.display = 'block';
    }
}

function doyouknow()
{
    if (document.getElementById('DoYouKnow').checked )
    {
        document.getElementById('sdoyouknow').style.display = 'block';
    } else
    {
        document.getElementById('sdoyouknow').style.display = 'none';
    }
}


