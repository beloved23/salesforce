
@extends('layouts.master')
@section('pagestyles')
    
@endsection

@section('content')
     <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Responsive Table </h3>
                            <p class="text-muted m-b-20">Create responsive tables by wrapping any <code>.table</code> in <code>.table-responsive </code></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>User</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #26589</a></td>
                                            <td>Herman Beck</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                            <td>$45.00</td>
                                            <td>
                                                <div class="label label-table label-success">Paid</div>
                                            </td>
                                            <td>EN</td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #58746</a></td>
                                            <td>Mary Adams</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 12, 2017</span> </td>
                                            <td>$245.30</td>
                                            <td>
                                                <div class="label label-table label-danger">Shipped</div>
                                            </td>
                                            <td>CN</td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #98458</a></td>
                                            <td>Caleb Richards</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> May 18, 2017</span> </td>
                                            <td>$38.00</td>
                                            <td>
                                                <div class="label label-table label-info">Shipped</div>
                                            </td>
                                            <td>AU</td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #32658</a></td>
                                            <td>June Lane</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Apr 28, 2017</span> </td>
                                            <td>$77.99</td>
                                            <td>
                                                <div class="label label-table label-success">Paid</div>
                                            </td>
                                            <td>FR</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@section('pagejs')
    
@endsection