<div class="productItem">
    <div class="row no-gutters">
        <div class="col-md-3">
            <div class="productItem-image">
                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                     data-src="{{ $src }}"
                     alt="{{ $name }}"
                     class="lazy-image a--full-width" width="400" height="400" />
            </div>
        </div>
        <div class="col-md-9">
            <div class="productItem-description">
                <div class="title">
                    {{ $name }}
                </div>
                <div class="action">

{{--                    <button type="button" class="btn btn-warning btn-lg">فیلم ها</button>--}}
{{--                    <button type="button" class="btn btn-secondary btn-lg">جزوات</button>--}}

                    <select class="CustomDropDown" id="selectProductSet">
                        <option value="1">item 1</option>
                        <option value="1">item 2</option>
                        <option value="1">item 3</option>
                        <option value="1">item 4</option>
                        <option value="1">item 5</option>
                        <option value="1">item 6</option>
                    </select>


                </div>
            </div>
        </div>
    </div>
</div>
