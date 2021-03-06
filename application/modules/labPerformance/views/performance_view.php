<div id="first">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          LAB PERFORMANCE STATS ON EID <div class="display_date"></div>
        </div>
        <div class="panel-body">
          <div id="lab_perfomance_stats"><center><div class="loader"></div></center></div>
          <div class="col-md-12" style="margin-top: 1em;margin-bottom: 1em;">
              
            </div>
        </div>
        
      </div>
    </div>
  </div>
  <div class="row">
    <div id="graphs">
    	
    </div>

    <div id="stacked_graph" class="col-md-6">

    </div>
  </div>

  <div id="lineargauge">

  </div>
</div>

<div id="second">
  <div id="lab_summary_two_years">
      
  </div>

  <div id="trends_lab">
      
  </div>
</div>

<div id="third">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Samples Rejections <div class="display_date"></div>
        </div>
        <div class="panel-body" id="lab_rejections">
          <center><div class="loader"></div></center>
        </div>
      </div>
    </div>
  </div>
  
</div>


<script type="text/javascript">

  $().ready(function() {
    $.get("<?php echo base_url();?>template/dates", function(data){
      obj = $.parseJSON(data);

    if(obj['month'] == "null" || obj['month'] == null){
      obj['month'] = "";
    }
    $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
    });

    localStorage.setItem("my_lab", 0);

    $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes");
    $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround");
    $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats");
    $("#lab_rejections").load("<?php echo base_url();?>charts/LabPerformance/rejections/0");

    $("button").click(function () {
        var first, second;
        first = $(".date-picker[name=startDate]").val();
        second = $(".date-picker[name=endDate]").val();

          var new_title = set_multiple_date(first, second);

          $(".display_date").html(new_title);
        
        from  = format_date(first);
        to    = format_date(second);
        var error_check = check_error_date_range(from, to);
          
        if (!error_check) {
          $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
          $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
          $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);

          var em = localStorage.getItem("my_lab");

          $("#lab_rejections").load("<?php echo base_url();?>charts/LabPerformance/rejections/"+em+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
        }
            
    });

    $("select").change(function(){
      em = $(this).val();
      em = parseInt(em);
      localStorage.setItem("my_lab", em);

      if(em == 0){
      
        $("#first").show();
        $("#second").hide();
        $("#breadcrum").hide();

        $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends");
        $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes");
        $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround");
        $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats");

        $(".display_date").load("<?php echo base_url('charts/labs/display_date'); ?>");

      }
      else{
        
        $("#first").hide();
        $("#second").show();
        $("#breadcrum").show();
        var t = $("#my_list option:selected").text();
        $("#breadcrum").html(t);
        $("#lab_summary_two_years").load("<?php echo base_url();?>charts/LabPerformance/summary/"+em);
        $("#trends_lab").load("<?php echo base_url();?>charts/LabPerformance/lab_trends/"+em);
        
      }

      $("#lab_rejections").html("<div>Loading...</div>");
      $("#lab_rejections").load("<?php echo base_url();?>charts/LabPerformance/rejections/"+em);
      
      });


  });
  

function date_filter(criteria, id)
  {
    if (criteria === "monthly") {
      year = null;
      month = id;
    }else {
      year = id;
      month = null;
    }

    var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

    // Put the results in a div
    posting.done(function( data ) {
      obj = $.parseJSON(data);
      console.log(obj);
      if(obj['month'] == "null" || obj['month'] == null){
        obj['month'] = "";
      }
      $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
      
    });
    
    
    $("#stacked_graph").html("<div>Loading...</div>");
    $("#lineargauge").html("<div>Loading...</div>");

    var em = localStorage.getItem("my_lab");
    
    if (criteria === "monthly") {
      $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes/"+year+"/"+month);
      $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround/"+year+"/"+month);
      $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats/"+year+"/"+month);

    }

    else{
      $("#graphs").html("<div>Loading...</div>");

      $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends/"+year);
      $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes/"+year+"/"+month);
      $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround/"+year+"/"+month);
      $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats/"+year+"/"+month);

      
      $("#lab_summary_two_years").html("<div>Loading...</div>");

      $("#lab_summary_two_years").load("<?php echo base_url();?>charts/LabPerformance/summary/"+em+"/"+year);

    }
      
      $("#lab_rejections").html("<div>Loading...</div>");
      $("#lab_rejections").load("<?php echo base_url();?>charts/LabPerformance/rejections/"+em+"/"+year+"/"+month);


    
  }
   
</script>