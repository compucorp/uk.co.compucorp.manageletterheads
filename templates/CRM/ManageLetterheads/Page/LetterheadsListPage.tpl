<div id="bootstrap-theme" class="crm-container">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="text-right">
        <button class="btn btn-large btn-primary">
          <i class="fa fa-plus-circle"></i>
          Create new letterhead
        </button>
      </div>
      {if !count($letterheads)}
        <div class="crm-case-custom-form-block-empty text-center clearfix">
          No Letterheads are available.
        <div>
      {/if}
    </div>
    {if count($letterheads)}
      <table class="table table-responsive table-striped">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Available for</th>
            <th>Order</th>
            <th>Enabled</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$letterheads item=letterhead}
            <tr>
              <td>{$letterhead.title}</td>
              <td>{$letterhead.description}</td>
              <td>{$letterhead.available_for}</td>
              <td>{$letterhead.weight}</td>
              <td>{$letterhead.is_active}</td>
              <td></td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    {/if}
  </div>
</div>
