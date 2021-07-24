import { ApiResponse } from "../interfaces/api-response";

export function checkResponse(response: ApiResponse) {
  return response.success;
}
