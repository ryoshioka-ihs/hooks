(function($, undefined) {
    smpMargeUtl.check_dmflg_disable = true;

  if (smpMargeUtl.isMatchUrl("/merger")) {
    smpMargeUtl.selectValue();
    smpMargeUtl.setGroupNames(["zip1_select", "zip2_select"]);
    smpMargeUtl.selectGroups();

    smpMargeUtl.setGroupNames(["address1_select", "address2_select", "address3_select", "address4_select",  "address5_select"]);
    smpMargeUtl.selectGroups();
  }

  if (smpMargeUtl.isMatchUrl("/visitordata/list")) {
    //smpMargeUtl.strictCheck({
    //  "VisitorData_D__P__D_name1": 1,
    //  "VisitorData_D__P__D_name2": 2,
    //  "VisitorData_D__P__D_email": 4
    //});
  }
}(jQuery));
