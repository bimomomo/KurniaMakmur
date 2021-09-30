<template>
  <div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Chrome Users</p>
                <h4 class="my-1">42K</h4>
              </div>
              <div class="text-primary ms-auto font-35">
                <i class="bx bxl-chrome"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Github Users</p>
                <h4 class="my-1">56M</h4>
              </div>
              <div class="text-danger ms-auto font-35">
                <i class="bx bxl-github"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Firefox Users</p>
                <h4 class="my-1">42M</h4>
              </div>
              <div class="text-warning ms-auto font-35">
                <i class="bx bxl-firefox"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Shopify Users</p>
                <h4 class="my-1">85M</h4>
              </div>
              <div class="text-success ms-auto font-35">
                <i class="bx bxl-shopify"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
Vue.use(VueApexCharts);

Vue.component("apexchart", VueApexCharts);
export default {};
</script>