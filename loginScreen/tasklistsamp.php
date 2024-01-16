<div class="flex items-center justify-center pt-10 ">
        <div class="overflow-x-auto w-full rounded-t-lg ">
            <table id="taskTable" class="table-auto min-w-full divide-y divide-gray-200 rounded-t-lg shadow-md  bg-white p-8 backdrop-filter backdrop-blur-lg bg-opacity-80">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Assigned to </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Edit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Delete</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <?php
require_once('config.php'); // Include your database connection

$sql = "SELECT id, title, description, due_date, priority FROM task_list";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $priority = ucwords(strtolower($row['priority']));
        $class = '';

        switch ($priority) {
            case 'High':
                $class = 'text-red-600 font-semibold';
                break;
            case 'Mid':
                $class = 'text-yellow-600 font-medium';
                break;
            case 'Low':
                $class = 'text-green-600 font-normal';
                break;
            default:
                $class = 'text-gray-700';
                break;
        }
        ?>

        <tr>
            <td class='px-6 py-4 text-sm font-semibold text-gray-800 task_title'><?= $row['title'] ?></td>
            <td class='px-6 py-4 text-sm text-gray-700  task_description'><?= $row['description'] ?></td>
            <td class='px-6 py-4 text-sm text-gray-700  task_date'><?= $row['due_date'] ?></td>
            <td class='px-6 py-4 text-sm <?= $class ?>'><?= $row['priority'] ?></td>
            <td class='px-6 py-4 text-sm <?= $class ?>'><?= $row['priority'] ?></td>
            <td class='px-6 py-4 text-sm'>
                <a href='edit_task.php?id=<?= $row['id'] ?>' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Edit</a>
            </td>
            <td class='px-6 py-4 text-sm'>
                <a href='delete_task.php?id=<?= $row['id'] ?>' onclick='return confirmDelete(<?= $row['id'] ?>);' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Delete</a>
            </td>
        </tr>

<?php
    }
} else {
    echo "<tr><td colspan='6' class='px-6 py-4 text-sm text-gray-500'>No tasks found.</td></tr>";
}
?>

            </tbody>
        </table>
    </div>
</div>