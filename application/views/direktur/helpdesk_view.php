<?php //print_r($antrian)?>

<div class="content">

    <h1>Jawab Pertanyaan</h1>

    <form method="post" action="<?php echo site_url('direktur/helpdesk/eskalasi') ?>">

        <fieldset>
            <legend>Identitas</legend>
            <div class="grid_6 alpha omega">
                <p>
                    <label style="display: inline-block; width: 100px;">No Tiket</label>
                    <span><?php echo $antrian->no_tiket_helpdesk ?></span>
                    <input type="hidden" name="no_tiket_helpdesk" value="<?php echo $antrian->no_tiket_helpdesk ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">No Satker</label>
                    <span><?php echo $antrian->id_satker ?></span>
                    <input type="hidden" name="id_satker" value="<?php echo $antrian->id_satker ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">Nama Satker</label>
                    <span><?php echo $antrian->nama_satker ?></span>
                    <input type="hidden" name="nama_satker" value="<?php echo $antrian->nama_satker ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">Nama Petugas</label>
                    <span><span><?php echo $antrian->nama_petugas ?></span></span>
                    <input type="hidden" name="nama_petugas" value="<?php echo $antrian->nama_petugas ?>"/>
                </p>

            </div>

            <div class="grid_6 alpha omega">

                <p>
                    <label style="display: inline-block; width: 100px;">No Kantor</label>
                    <span><?php echo $antrian->no_kantor ?></span>
                    <input type="hidden" name="no_kantor" value="<?php echo $antrian->no_kantor ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">No HP</label>
                    <span><?php echo $antrian->no_hp ?></span>
                    <input type="hidden" name="no_hp" value="<?php echo $antrian->no_hp ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">Email</label>
                    <span><?php echo $antrian->email ?></span>
                    <input type="hidden" name="email" value="<?php echo $antrian->email ?>"/>
                </p>
            </div>
        </fieldset>


        <fieldset>
            <legend>Pertanyaan</legend>
            <div class="grid_6 alpha omega">

                <p>
                    <label style="display: inline-block; width: 100px;">Kategori</label>
                    <span><?php //echo $antrian->kategori ?></span>
                    <input type="hidden" name="kategori" value="<?php //echo $antrian->kategori ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">Pertanyaan</label>
                    <span><?php echo $antrian->pertanyaan ?></span>
                    <input type="hidden" name="pertanyaan" value="<?php echo $antrian->pertanyaan ?>"/>
                </p>

            </div>

            <div class="grid_6 alpha omega">

                <p>
                    <label style="display: inline-block; width: 100px;">Deskripsi</label>
                    <span><?php echo $antrian->description ?></span>
                    <input type="hidden" name="description" value="<?php echo $antrian->description ?>"/>
                </p>

                <p>
                    <label style="display: inline-block; width: 100px;">Prioritas</label>
                    <span><?php echo $antrian->prioritas ?></span>
                    <input type="hidden" name="prioritas" value="<?php echo $antrian->prioritas ?>"/>
                </p>

            </div>
        </fieldset>

        <fieldset>
            <legend>Jawaban</legend>

            <div class="grid_5">
            <p>
                <label>
                    <textarea name="jawaban" rows="7" cols="120"></textarea>
                </label>
            </p>
            </div>

            <div class="grid_5">
            <p>
                <label style="display: inline-block; width: 100px;">Nama Nara Sumber: </label>
                <span><input name="nama_narasumber" type="text"/></span>
            </p>

            <p>
                <label style="display: inline-block; width: 100px;">Jabatan</label>
                <span><input name="jabatan" type="text"/></span>
            </p>

            <p>
                <label style="display: inline-block; width: 100px;">Bukti File</label>
                <span><input name="file" type="file"/></span>
            </p>
            </div>

        </fieldset>

        <div>
            <label><input name="sendmail" type="checkbox"/> Kirim jawaban ke email petugas Satker </label>
        </div>

        <div style="float: left;">
            <a class="button" href="<?php echo site_url('direktur/helpdesk') ?>">Batal</a>
        </div>

        <div style="float: right;">

            <input type="button" onclick="window.print()" value="Print" class="button gray-pill"/>
<!--            <input type="submit" name="submit" value="Eskalasi" class="button blue" onlick="return false"/>-->
            <input type="submit" name="submit" value="Jawab" class="button green"/>
        </div>

        <div class="clear"></div>

    </form>
</div>