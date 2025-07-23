<style>
    .overviews {
        padding: 10px;
        display: flex;
        gap: 10px;
    }

    .overviews .item {
        width: 100%;
        color: ;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid gray;
        border-radius: 8px;
        padding: 10px 0;
    }

    .overviews .item h4 {
        font-weight: light;
    }
</style>
<div class="dashboard-container container-fluid py-4">
    <!-- Stats Cards Row -->
    <div class="overviews">
        <div class="item">
            <h1><i class="fas fa-utensils"></i></h1>
            <h5>Dishes</h5>
            <h4>68</h4>
        </div>
        <div class="item">
            <h1><i class="fas fa-shopping-cart"></i></h1>
            <h5>Orders</h5>
            <h4>68</h4>
        </div>
        <div class="item">
            <h1><i class="fas fa-tags"></i></h1>
            <h5>Categories</h5>
            <h4>90</h4>
        </div>
        <div class="item">
            <h1><i class="fas fa-spinner fa-spin"></i></h1>
            <h5>Pending Orders</h5>
            <h4>68</h4>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activity</h5>
                    <a href="#" class="btn btn-sm btn-outline-secondary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-1254</td>
                                    <td>John Smith</td>
                                    <td><span class="badge bg-warning text-dark">Complaint</span></td>
                                    <td><span class="badge bg-danger">Pending</span></td>
                                    <td>10 min ago</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Resolve</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#ORD-1253</td>
                                    <td>Sarah Johnson</td>
                                    <td><span class="badge bg-info">Feedback</span></td>
                                    <td><span class="badge bg-success">Resolved</span></td>
                                    <td>1 hour ago</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#ORD-1251</td>
                                    <td>Michael Brown</td>
                                    <td><span class="badge bg-warning text-dark">Complaint</span></td>
                                    <td><span class="badge bg-secondary">In Progress</span></td>
                                    <td>3 hours ago</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Resolve</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>