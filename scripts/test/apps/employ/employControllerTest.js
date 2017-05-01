/**
 * @author dmans
 */
describe('employListCtrl', function(){

	beforeEach(module('employApps'));
	
	

  it('should create "phones" model with 3 phones', function() {
    var scope = {},
        ctrl = new employListCtrl(scope);
	expect(scope.store.sto_name).
    expect(scope.phones.length).toBe(3);
  });

});