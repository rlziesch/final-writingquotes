<?php include('header.php') ?>
<nav>
    <form action="." method="get" id="make_selection">

        <section id="dropmenus" class="dropmenus">
            <input type="hidden" name="action" value="list_quotes">

            <?php if ($authors) { ?>
            <label>Authors:</label>
            <select name="authorId">
                <option value="0">View All Authors</option>

                <?php foreach ($authors as $author) : ?>
                <?php if ($author['id'] == $authorId) { ?>
                <option value="<?= $author['id']; ?>" selected>
                    <?php } else { ?>
                <option value="<?= $author['id']; ?>">
                    <?php } ?>
                    <?= $author['author']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php } ?>


            <?php if ($categories) { ?>
            <label>Categories:</label>
            <select name="categoryId">
                <option value="0">View All Categories</option>
                <?php foreach ($categories as $category) : ?>
                <?php if ($category['id'] == $categoryId) { ?>
                <option value="<?= $category['id']; ?>" selected>
                    <?php } else { ?>
                <option value="<?= $category['id']; ?>">
                    <?php } ?>
                    <?= $category['category']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php } ?>

            <input type="submit" value="submit" class="button blue button-slim">
        </section>
       
    </form>
</nav>
<section>
    <?php if($quotes) { ?>
    <div id="table-overflow-customer" class="table-overflow-customer">
        <table>
            <thead>
                <tr>
                    <th>Quote</th>
                    <th>Author</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotes as $quote) : ?>
                <tr>
                    <td><?= $quote['quote']; ?></td>
                    <?php if ($quote['author']) { ?>
                    <td><?= $quote['author']; ?></td>
                    <?php } else { ?>
                    <td>None</td>
                    <?php } ?>

                    <?php if ($quote['category']) { ?>
                    <td><?= $quote['category']; ?></td>
                    <?php } else { ?>
                    <td>None</td>
                    <?php } ?>
                    
                    
                  
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } else { ?>
    <p>
        There are no matching quotes.
    </p>
    <?php } ?>
</section>



<?php include('footer.php') ?>