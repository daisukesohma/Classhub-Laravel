
<div id="filter-results" class="col-md-4">
  <div class="row title-type-01">
      <div class="col-sm-12">
          <div class="title p-b-10 filter-results-title">Filter Results</div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div id="filters">
          <div id="filter-price">
            <label class="filter-label">Filter by price</label>
            <select class="form-control">
              <option value="high to low">High to Low</option>
              <option value="low to high">Low to High</option>
            </select>
            <div class="slider-styled" id="price-range-slider"></div>
            <span id="price-values">€<span class="example-val" id="price-range-slider-value">0.00 - €0.00</span></span>
          </div>

          <div id="filter-level">
            <label class="filter-label">Filter by Tutor Level</label><br>
            <div id="tutor-level-options">
              <label class="fs-13"><input type="radio" name="tutors-filter" checked> All Tutors</label>
              <label class="fs-13"><input type="radio" name="tutors-filter" checked> Trusted</label>
              <label class="fs-13"><input type="radio" name="tutors-filter" checked> Top Performers</label>
            </div>
          </div>

          <div id="filter-time">
            <label class="filter-label">Filter by Time</label><br>
            <div class="row">
              <div class="col-sm-12 col-md-5">
                <input
                    type="text"
                    class="form-control timepicker"
                    name="to"
                    value="From">
              </div>
              <div class="col-md-2 text-center">
                <span class="from-to-hyphen" style="margin-top: 10px; display: block">-</span>
              </div>
              <div class="col-sm-12 col-md-5">
                <input
                    type="text"
                    class="form-control timepicker"
                    name="to"
                    value="To">
              </div>
            </div>
          </div>
          <button class="btn btn-brand w-100">Update Results</button>
        </div>
      </div>
  </div>
</div>
