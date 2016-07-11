    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="wishList">
            

            </div>
        </div>
    </section>



<script>
var getWishList = function() {
	$("#wishList").load('/proc/mymenu/wishlist.php?mod=<?=$mod?>&submode=wishlist');
}

getWishList(); 
</script>




