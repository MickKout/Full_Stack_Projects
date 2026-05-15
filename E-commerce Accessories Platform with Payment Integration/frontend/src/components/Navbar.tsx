interface AuthUser {
  id: number
  name: string
  email: string
  role: 'admin' | 'user'
}

interface NavbarProps {
  user: AuthUser
  onLogout: () => void
}

export default function Navbar({ user, onLogout }: NavbarProps) {
  return (
    <nav className="bg-white border-b border-gray-200 shadow-sm">
      <div className="container mx-auto px-4 py-4 flex justify-between items-center">
        <div className="flex items-center gap-8">
          <h1 className="text-2xl font-bold text-primary-600">E-Commerce</h1>
          <div className="text-sm text-gray-600">
            {user.role === 'admin' && (
              <span className="badge-success">Admin</span>
            )}
            {user.role === 'user' && (
              <span className="badge-warning">Customer</span>
            )}
          </div>
        </div>

        <div className="flex items-center gap-6">
          <div className="text-sm">
            <p className="font-medium text-gray-900">{user.name}</p>
            <p className="text-gray-500">{user.email}</p>
          </div>

          <button
            onClick={onLogout}
            className="btn-outline px-4 py-2"
          >
            Sign Out
          </button>
        </div>
      </div>
    </nav>
  )
}
