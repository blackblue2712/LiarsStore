
<div class="list-movie-filter" style="margin-bottom: 10px;" id="list-movie-filter">
    <div class="list-movie-filter-main">
        <form id="adminForm" class="form-inline" method="POST" action="#">
            
            <div class="list-movie-filter-item">
                <label for="filter-category">Thể loại</label>
                <span class="multiselect-native-select">
                    <select style="margin-top: 5px;" class="multiselect-native-select" id="filter-category" name="genres" multiple="multiple">
                        <option value="38">Đời Thường</option>
                        <option value="36">Harem</option>
                        <option value="35">Shounen</option>
                        <option value="33">Học Đường</option>
                    </select>
                    <div style="margin-top: 5px;" class="btn-group">
                        <button type="button" class="multiselect dropdown-toggle form-control selectpicker" data-toggle="dropdown" title="Genres"><span class="multiselect-selected-text">Genres</span> <b class="caret"></b></button>
                        <ul class="multiselect-container dropdown-menu">
                        <?php echo $xCateForSorting ?>
                        </ul>
                    </div>
                </span>
            </div>

            <div class="list-movie-filter-item">
                <label for="filter-country">Theo mùa</label>
                <select class="form-control" id="filter-country" name="season">
                    <option value="">Tất cả</option>
                    <option value="5">Xuân</option>
                </select>
            </div>
            <div class="list-movie-filter-item">
                <label for="filter-year">Năm phát hành</label>
                <select id="filter-year" name="year" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                </select>
            </div>
            <div class="list-movie-filter-item">
                <label for="filter-sort">Sắp xếp</label>
                <select class="form-control" id="filter-sort" name="sort">
                    <option value="popular">Lượt xem</option>
                    <option value="comment">Bình luận</option>
                    <option value="year">Năm</option>
                </select>
            </div>
            <button type="submit" id="btn-movie-filter" class="btn btn-red btn-filter-movie"><span>Duyệt phim</span></button>
            <div class="clear"></div>
            <input type="hidden" name="filter_page" value="1">
        </form>
    </div>

    <!-- FOR PAGINATION -->
    
</div>
<?php
    if(isset($this->params["form"]["search_category"])){
        foreach($this->params["form"]["search_category"] as $value){
            echo Helper::createScriptChecked(".multiselect-container li label.checkbox", $value);    
        }
    }  
?>