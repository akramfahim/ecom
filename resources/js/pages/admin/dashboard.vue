<template>
    <div>
        <h1>Dashboard Page</h1>

        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <router-link to="/orders" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Products</p>
              </div>
              <div class="icon">
                <i class="fas fa-list-alt"></i>
              </div>
              <router-link to="/products" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>Customers List</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <router-link to="/customers" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Admin User</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <router-link to="/adminusers" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
          <!-- ./col -->
        </div>
    </div>
</template>