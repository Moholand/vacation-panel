<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <h5 class="modal-title" id="confirmModalLabel">هشدار!!!</h5>
        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        آیا مایل به
        <span class="font-weight-bold confirm-modal-title">{{ $title }}</span>
        می‌باشید؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="confirmBtn">تأیید</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
      </div>
    </div>
  </div>
</div>