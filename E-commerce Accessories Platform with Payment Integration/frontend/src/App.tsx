import { useState } from 'react'
import Login from './pages/Login'
import Register from './pages/Register'
import AdminDashboard from './pages/AdminDashboard'
import Navbar from './components/Navbar'

interface AuthUser {
  id: number
  name: string
  email: string
  role: 'admin' | 'user'
}

interface AuthData {
  user: AuthUser
  token: string
  refreshToken?: string
}

type Page = 'login' | 'register' | 'dashboard' | 'checkout'

export default function App() {
  const [auth, setAuth] = useState<AuthData | null>(null)
  const [currentPage, setCurrentPage] = useState<Page>('login')
  const userRole = localStorage.getItem('role') as 'admin' | 'user' | null

  const handleLogout = () => {
    localStorage.removeItem('token')
    localStorage.removeItem('refreshToken')
    localStorage.removeItem('role')
    setAuth(null)
    setCurrentPage('login')
  }

  const handleSwitchPage = (page: Page) => {
    setCurrentPage(page)
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {auth && <Navbar user={auth.user} onLogout={handleLogout} />}

      <main className="container mx-auto px-4 py-8">
        {!auth ? (
          <div className="max-w-md mx-auto">
            {currentPage === 'login' ? (
              <>
                <Login setAuth={setAuth} onSwitchPage={handleSwitchPage} />
              </>
            ) : (
              <>
                <Register setAuth={setAuth} onSwitchPage={handleSwitchPage} />
              </>
            )}
          </div>
        ) : userRole === 'admin' ? (
          <AdminDashboard />
        ) : (
          <div className="text-center py-12">
            <h2 className="text-3xl font-bold text-gray-900 mb-4">Checkout</h2>
            <p className="text-gray-600">Checkout functionality coming soon</p>
          </div>
        )}
      </main>
    </div>
  )
}
