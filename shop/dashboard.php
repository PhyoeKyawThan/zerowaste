<style>
    .overviews {
        padding: 10px;
        display: flex;
        gap: 10px;
    }

    .overviews .item {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid gray;
        border-radius: 8px;
        padding: 10px 0;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .overviews .item h4 {
        font-weight: lighter;
        margin-top: 5px;
        font-size: 1.5rem;
    }

    .overviews .item h5 {
        margin-bottom: 5px;
        color: #666;
    }

    .overviews .item h1 {
        font-size: 2rem;
        margin-bottom: 5px;
    }

    .item.dishes { color: #4e73df; }
    .item.claims { color: #1cc88a; }
    .item.pending { color: #f6c23e; }

    @media screen and (max-width: 700px){
        .overviews{
            flex-direction: column;
        }
        .desktop-table{
            display: none;
        }
        .mobile-cards{
            display: block;
        }
    }

    @media screen and (min-width: 701px){
        .mobile-cards{
            display: none;
        }
    }
</style>

<div class="dashboard-container container-fluid py-4">
    <?php
    $restaurant_id = $_SESSION['rs_id'];
    
    $dishes_q = mysqli_query($db, "SELECT COUNT(*) as total FROM dishes WHERE rs_id = '$restaurant_id'");
    $dishes_data = mysqli_fetch_assoc($dishes_q);
    $total_dishes = $dishes_data['total'];
    
    $claims_q = mysqli_query($db, "SELECT COUNT(*) as total FROM users_claims uc JOIN dishes d ON uc.d_id = d.d_id WHERE d.rs_id = '$restaurant_id'");
    $claims_data = mysqli_fetch_assoc($claims_q);
    $total_claims = $claims_data['total'];
    
    $pending_q = mysqli_query($db, "SELECT COUNT(*) as total FROM users_claims uc JOIN dishes d ON uc.d_id = d.d_id WHERE d.rs_id = '$restaurant_id' AND (uc.status IS NULL OR uc.status = '' OR uc.status = 'in process')");
    $pending_data = mysqli_fetch_assoc($pending_q);
    $pending_claims = $pending_data['total'];

    if(isset($_GET['action']) && $_GET['action'] == 'make_finished'){
        $id = $_GET['id'];
        mysqli_query($db, "UPDATE users_claims SET status = 'Finished' WHERE id = $id");
    }
    ?>
    
    <div class="overviews">
        <div class="item dishes">
            <h1><i class="fas fa-utensils"></i></h1>
            <h5>အစားအသောက်များ</h5>
            <h4><?= $total_dishes ?></h4>
        </div>
        <div class="item claims">
            <h1><i class="fas fa-inbox"></i></h1>
            <h5>စုစုပေါင်း အော်ဒါများ</h5>
            <h4><?= $total_claims ?></h4>
        </div>
        <div class="item pending">
            <h1><i class="fas fa-spinner fa-spin"></i></h1>
            <h5>စောင့်‌ဆိုင်းနေဆဲ အော်ဒါများ</h5>
            <h4><?= $pending_claims ?></h4>
        </div>
    </div>

    <div class="desktop-table">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">လတ်တလော အော်ဒါများ</h5>
                        <a href="shop.php?p=claims" class="btn btn-sm btn-outline-secondary">ကြည့်ရှုရန်</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>အော်ဒါ အမှတ်စဉ်</th>
                                        <th>စားသုံးသူ</th>
                                        <th>အစားအသောက်</th>
                                        <th>အရေအတွက်</th>
                                        <th>အော်ဒါ အခြေအနေ</th>
                                        <th>ရက်စွဲ</th>
                                        <th>လုပ်ဆောင်ချက်</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent_claims = mysqli_query($db, 
                                        "SELECT uc.id, u.username, d.title, uc.quantity, uc.status, uc.date 
                                         FROM users_claims uc
                                         JOIN users u ON uc.u_id = u.u_id
                                         JOIN dishes d ON uc.d_id = d.d_id
                                         WHERE d.rs_id = '$restaurant_id'
                                         ORDER BY uc.date DESC LIMIT 5");
                                    
                                    if(mysqli_num_rows($recent_claims) > 0) {
                                        while($claim = mysqli_fetch_assoc($recent_claims)) {
                                            $status_class = '';
                                            $status_text = '';
                                            
                                            if($claim['status'] == "" || $claim['status'] == "Pending") {
                                                $status_class = 'warning text-dark';
                                                $status_text = 'စောင့်ဆိုင်းဆဲ';
                                            } elseif($claim['status'] == "Approved") {
                                                $status_class = 'primary';
                                                $status_text = 'အတည်ပြုပြီး';

                                            }elseif($claim['status'] == 'Finished'){
                                                $status_class = 'success';
                                                $status_text = 'Finished';
                                            } else {
                                                $status_class = 'danger';
                                                $status_text = 'မအောင်မြင်ပါ';
                                            }
                                            ?>
                                            <tr>
                                                <td>#<?= $claim['id'] ?></td>
                                                <td><?= htmlspecialchars($claim['username']) ?></td>
                                                <td><?= htmlspecialchars($claim['title']) ?></td>
                                                <td><?= $claim['quantity'] ?></td>
                                                <td><span class="badge bg-<?= $status_class ?> text-white rounded" style="padding: 3px 10px;"><?= $status_text ?></span></td>
                                                <td><?= date('M j, Y g:i A', strtotime($claim['date'])) ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="?p=claims&action=edit&id=<?= $claim['id'] ?>" class="btn btn-sm btn-outline-primary">ကြည့်ရှုရန်</a>
                                                        <?php
                                                            if($claim['status'] != 'Pending'):
                                                        ?>
                                                            <a href="?p=dashboard&action=make_finished&id=<?= $claim['id'] ?>" class="btn btn-sm btn-outline-success"><?= $claim['status'] == 'Approved' ? 'Waiting' : 'Finished' ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center py-4">လတ်တလော အော်ဒါများ မရှိပါ</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-cards mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Claims</h5>
                <a href="?action=claims" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body">
                <?php
                mysqli_data_seek($recent_claims, 0); 
                
                if(mysqli_num_rows($recent_claims) > 0) {
                    while($claim = mysqli_fetch_assoc($recent_claims)) {
                        $status_class = '';
                        $status_text = '';
                        
                        if($claim['status'] == "Pending") {
                            $status_class = 'info';
                            $status_text = 'In Process';
                        } elseif($claim['status'] == "Approved") {
                            $status_class = 'success';
                            $status_text = 'Completed';
                        } elseif($claim['status'] == "Rejected") {
                            $status_class = 'danger';
                            $status_text = 'Rejected';
                        }
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">#<?= $claim['id'] ?></h6>
                                    <span class="badge bg-<?= $status_class ?>"><?= $status_text ?></span>
                                </div>
                                <p class="card-text mb-1"><small class="text-muted">Customer:</small> <?= htmlspecialchars($claim['username']) ?></p>
                                <p class="card-text mb-1"><small class="text-muted">Dish:</small> <?= htmlspecialchars($claim['title']) ?></p>
                                <p class="card-text mb-1"><small class="text-muted">Quantity:</small> <?= $claim['quantity'] ?></p>
                                <p class="card-text"><small class="text-muted">Date:</small> <?= date('M j, Y g:i A', strtotime($claim['date'])) ?></p>
                                
                                <div class="d-flex gap-2 mt-2">
                                    <a href="?action=edit&id=<?= $claim['id'] ?>" class="btn btn-sm btn-outline-primary flex-fill">View</a>
                                    <?php if($claim['status'] != 'closed' && $claim['status'] != 'rejected'): ?>
                                        <a href="?action=resolve&id=<?= $claim['id'] ?>" class="btn btn-sm btn-outline-success flex-fill">Resolve</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="text-center py-4">လတ်တလော အော်ဒါများ မရှိပါ။</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>