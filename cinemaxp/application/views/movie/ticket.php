<div class="row content">
    <div class="col">
        <div class="card">
            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-left" style="width: 60%"><h4>Your Tickets</h4></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">Cinema</td>
                            <td class="text-left"><?php echo $ticket['name']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Movie</td>
                            <td class="text-left"><?php echo $ticket['title']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Showtime</td>
                            <td class="text-left"><?php echo $ticket['showtime']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Seats</td>
                            <td class="text-left">
                            <?php foreach($seats as $seat){
                                echo $seat['seat_row'].$seat['seat_column']."<br>";
                            } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
