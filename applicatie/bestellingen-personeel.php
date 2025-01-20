        <?php include 'header.php'; ?>

        <main>
            <table>
                <thead>
                    <tr>
                        <th>Bestelnummer</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="bestelling-detail.php">#1234</a></td>
                        <td>2x Margherita, 1x Pepperoni</td>
                        <td>In de oven</td>
                        <td>
                            <div class="status-container">
                                <select>
                                    <option value="in-oven">In de oven</option>
                                    <option value="onderweg">Onderweg</option>
                                    <option value="bezorgd">Bezorgd</option>
                                </select>
                                <button class="update-status-btn">Status Wijzigen</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="bestelling-detail.php">#1235</a></td>
                        <td>1x Hawaiian</td>
                        <td>Onderweg</td>
                        <td>
                            <div class="status-container">
                                <select>
                                    <option value="in-oven">In de oven</option>
                                    <option value="onderweg">Onderweg</option>
                                    <option value="bezorgd">Bezorgd</option>
                                </select>
                                <button class="update-status-btn">Status Wijzigen</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </body>
</html>
