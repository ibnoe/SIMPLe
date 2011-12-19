<ul id="nav">
    <li><a href="#tab1" class="active">Manajemen Ubah Forum</a></li>
</ul>
<div class="clear"></div>
    <div id="konten">
        <div style="display: none;" id="tab1" class="tab_konten">


            <div class="table">
                <form action="<?php echo site_url('/admin/man_forum/update_forum'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8"
                      style="border: 1px solid #999; padding: 13px 30px 13px 13px; margin:5px 0px 0px 20px; font-size:12px">
					  <?php if (isset($forum->id_forum)) echo form_hidden('id', $forum->id_forum);?>
                    <table>
                        <tr>
                            <td width="100px">Kategori Forum</td>
                            <td>:</td>
                            <td>
                                <select name="id_kat_forum">
                                   <?php foreach ($categories->result() as $category):
										$e = ($category->id_kat_forum == $forum->id_kat_forum)?'selected':'';
								   ?>
										
										<option value="<?php echo $category->id_kat_forum ?>" <?php echo $e;?>><?php echo $category->kat_forum ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td><input type="text" size="65" value="<?php echo $forum->judul_forum;?>" name="judul_forum"/></td>
                        </tr>
                        <tr>
                            <td valign="top">Isi</td>
                            <td valign="top">:</td>
                            <td><textarea cols="58" rows="15" name="isi_forum"><?php echo $forum->isi_forum;?></textarea></td>
                        </tr>
                        <tr>
                            <td valign="top">Lampiran</td>
                            <td valign="top">:</td>
                            <td><input type="file" name="lampiran"><?php echo $forum->file?></td>
                        </tr>
                    </table>
					<input class="button blue-pill" type="submit" value="Ubah"/>
					<a href="<?php echo site_url('/admin/man_forum') ?>" class="button gray-pill">Batal</a>
                </form>
                
            </div>

