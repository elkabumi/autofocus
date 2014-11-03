<script src="<?=base_url()?>assets/js/chart/jquery.js"></script>



<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Total'
                },
                labels: {
                    formatter: function() {
                        return this.value 
                    }
                }
            },

            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#fff',
                        lineWidth: 1
                    },
                     dataLabels: {
                        enabled: true
                    }
                }
            },
            <?php
                $year = date("Y");
                $data_po = "";
                 for($i=1; $i<=12; $i++){
                   $po = ($this->dashboard_model->get_data_po($i, $year)) ? $this->dashboard_model->get_data_po($i, $year) : 0;

                    if($i == 12){
                        $data_po .= $po;
                    }else{
                        $data_po .= $po.",";
                    }
                }

                 $data_re = "";
                 for($j=1; $j<=12; $j++){
                   $re = ($this->dashboard_model->get_data_re($j, $year)) ? $this->dashboard_model->get_data_re($j, $year) : 0;

                    if($j == 12){
                        $data_re .= $re;
                    }else{
                        $data_re .= $re.",";
                    }
                }
                
            ?>
            series: [{
                name: 'PO Order',
                
                 data: [<?= $data_po; ?>]
    
            }, {
                name: 'PO Reservation',
                marker: {
                    symbol: 'square'
                },
                data: [<?= $data_re ?>]
            }]
        });
    });
    

        </script>
        <script src="<?=base_url()?>assets/js/chart/highcharts.js"></script>
<script src="<?=base_url()?>assets/js/chart/exporting.js"></script>

<div class="row" id="refresh">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <?= $data_po_received?>
                                    </h3>
                                    <p>
                                        PO Received
                                      
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="<?=base_url()?>po_received" class="small-box-footer">
                                    Detail <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?= $data_po_reservation ?>
                                    </h3>
                                    <p>
                                        PO Reservation
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-cart-outline"></i>
                                </div>
                                <a href="<?=base_url()?>po_reservation" class="small-box-footer">
                                    Detail <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?= $data_po_retur ?>
                                    </h3>
                                    <p>
                                       PO Retur
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-briefcase-outline"></i>
                                </div>
                                <a href="<?=base_url()?>po_retur" class="small-box-footer">
                                    Detail  <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                         <?= $data_user_on ?>
                                    </h3>
                                    <p>
                                        User Online
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="<?=base_url()?>list_user" class="small-box-footer">
                                    
                                    Detail
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row --><!-- /.row --><!-- /.row -->
                    

<div class="row">
                       
                        
                        <div class="col-md-12">
                            <!-- LINE CHART -->
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">PO Chart Report   
                                       
                    </h3>
                                </div>
                                
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                            </div><!-- /.box -->
								
                         
                          

                        </div><!-- /.col (RIGHT) -->
                    </div><!-- /.row -->
                    


