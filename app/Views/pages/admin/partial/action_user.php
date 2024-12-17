<div class="dropdown">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
        Actions
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#editModal<?= $user['id_user'] ?>" data-id="<?= $user['id_user'] ?>"
                data-user='<?= json_encode($user) ?>' onclick="setEditModalData(this)">
                <i class="bx bx-edit-alt me-2"></i> Edit
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#deleteModal<?= $user['id_user'] ?>" data-id="<?= $user['id_user'] ?>"
                onclick="setDeleteModalData(this)">
                <i class="bx bx-trash me-2"></i> Delete
            </a>
        </li>
    </ul>
</div>
