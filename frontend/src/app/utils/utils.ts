import { ApiResponse } from "../interfaces/api-response";

export function checkResponse(response: ApiResponse) {
  return response.success;
}

export function createApiResponse(response: any): ApiResponse {
  const apiResponse: ApiResponse = { success: false, message: '', data: [ {} ] };
  if (!response.hasOwnProperty('success')) {
    throw new Error('broken response');
  }

  apiResponse.success = response.success;


  if (response.hasOwnProperty('data')) {
    apiResponse.data = response.data;
  }

  if (response.hasOwnProperty('message')) {
    apiResponse.message = response.message;
  }

  return apiResponse;

}
