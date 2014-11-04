<form action="<?php echo home_url( '/' ); ?>" method="get" class="form-inline">
    <fieldset>
        <div class="input-group">
            <input type="hidden" name="post_type" value="cartinha" />
            <input type="text" name="s" id="search" placeholder="Pesquisar" value="<?php the_search_query(); ?>" class="form-control" />
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">Pesquisar</button>
            </span>
        </div>
    </fieldset>
</form>
