<div id="manually-rename-storefronts" class="page">

    <h3><span class="label label-danger">Manually Rename Storefronts</span></h3>

    <h2 class="pull-left">Centre:</h2>
    <div class="col-xs-3 pull-left">
        <select class="form-control" name="centre">
            <?php foreach ($this->centres as $c): ?>
                <option value="<?=$c?>"<?=$c===$this->centre?' selected':''?>><?=$c?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Buttons -->
    <a class="btn btn-default pull-left view-centre" href="?task=manually-rename-storefronts&centre=<?=$this->centre?>" style="margin-right:10px;">View Centre</a>
    <a class="btn btn-primary pull-right" href="?task=batch-rename-storefronts&centre=<?=$this->centre?>" style="margin-left:10px;">Batch Rename</a>

    <!-- Stats -->
    <ol class="breadcrumb pull-right">
        <li><b><?=count($this->storefronts)?></b> retailers remaining</li>
        <li><b><?=count($this->files)?></b> images to rename</li>
    </ol>

    <?php if (count($this->files) === 0): ?>
        <p style="clear:both;">There are no files to rename.</p>
    <?php else: ?>
    <div class="col-xs-6 img">
        <img src="<?=$this->folder?>/<?=$this->file?>" />
    </div>

    <div class="col-xs-6">
        <h4>Select Retailer</h4>
        <form role="form" class="clearfix" method="post">
            <div class="form-group">
                <select class="form-control retailer">
                    <option disabled selected>Select Retailer</option>
                    <?php foreach ($this->storefronts as $s): ?>
                        <option data-retail-chain-id="<?=$s['retail_chain_id']?>" data-retailer-id="<?=$s['retailer_id']?>"><?=$s['name']?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="folder" value="<?=$this->folder?>" />
                <input type="hidden" name="old_filename" value="<?=$this->file?>" />
                <input type="hidden" name="new_filename" value="" />
            </div>
            <button type="submit" name="submit" class="btn btn-success pull-left" disabled>Rename</button>
            <a class="btn btn-default pull-right" href="?task=manually-rename-storefronts&centre=<?=$this->centre?>&offset=<?=$this->offset?>" style="margin-right:10px;">Next Image</a>
        </form>
        <hr />
        <h4>New Name</h4>
        <div class="well">
            <h4 class="new-filename"><b><span class="retail-chain-id">XXXX</span>_<?=$this->centre?>_<span class="retailer-id">XXXX</span>_storefront.jpg</b></h4>
        </div>
        <hr />
        <h4>Old Name</h4>
        <p class="old-filename"><b><?=$this->file?></b></p>
        <hr />
        <h4>Folder</h4>
        <p><?=$this->folder?>/</p>
    </div>
    <?php endif; ?>

</div>